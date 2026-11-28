<?php

namespace App\Services;

use App\Imports\RawSheetImport;
use App\Models\Website;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Maatwebsite\Excel\Facades\Excel;
use RuntimeException;
use Throwable;

class WebsiteCredentialImporter
{
    public const FIELDS = ['db_host', 'db_name', 'db_username', 'db_password', 'db_port'];

    public const WP_FIELDS = ['consumer_key', 'consumer_secret'];

    public const ENCRYPTED_FIELDS = ['db_host', 'db_name', 'db_username', 'db_password', 'db_port', 'consumer_key', 'consumer_secret'];

    private const MAX_ROWS = 2000;

    private const HEADERS = [
        'domain'      => ['domain', 'domainname', 'website', 'site', 'sitelink', 'url', 'sitename'],
        'db_host'     => ['ipaddress', 'ip', 'host', 'dbhost', 'server', 'serverip'],
        'db_name'     => ['dbname', 'database', 'databasename'],
        'db_username' => ['username', 'user', 'dbusername', 'dbuser'],
        'db_password' => ['password', 'pass', 'dbpassword', 'dbpass'],
        'db_port'     => ['port', 'dbport'],
    ];

    private const WP_HEADERS = [
        'domain'          => ['domain', 'domainname', 'website', 'site', 'sitelink', 'url', 'sitename'],
        'consumer_key'    => ['consumerkey', 'ck', 'key', 'apikey', 'wckey', 'woocommercekey'],
        'consumer_secret' => ['consumersecret', 'cs', 'secret', 'apisecret', 'wcsecret', 'woocommercesecret'],
    ];

    public function parse(UploadedFile $file, string $type = 'db'): array
    {
        $extension = strtolower($file->getClientOriginalExtension());

        $matrix = in_array($extension, ['xlsx', 'xls'], true)
            ? $this->readSpreadsheet($file)
            : $this->readDelimited($file->getRealPath());

        return $this->rowsFromMatrix($matrix, $type);
    }

    public function buildPlan(array $rows, string $type = 'db'): array
    {
        $websites = Website::query()->get()->keyBy('id');
        $index = $this->indexWebsites($websites);

        $items = [];
        $groups = [];

        foreach ($rows as $row) {
            $key = $this->normalizeDomain($row['domain']);

            if ($key === '') {
                $items[] = $this->item([$row['line']], $row['domain'], 'invalid', null, null, [], 'Domain is empty.');
                continue;
            }

            $groups[$key][] = $row;
        }

        $candidates = [];

        foreach ($groups as $key => $group) {
            $lines = array_column($group, 'line');
            $merged = $this->mergeGroup($group, $type);

            if ($merged === null) {
                $items[] = $this->item($lines, $key, 'conflict', null, null, [], 'Same domain appears on lines ' . implode(', ', $lines) . ' with different values.');
                continue;
            }

            if (count(array_filter($merged, fn ($value) => $value !== '')) === 0) {
                $items[] = $this->item($lines, $key, 'no_data', null, null, [], 'No credential values on this row.');
                continue;
            }

            $invalid = $this->validateValues($merged, $type);

            if ($invalid !== null) {
                $items[] = $this->item($lines, $key, 'invalid', null, null, [], $invalid);
                continue;
            }

            $ids = $this->matchWebsites($key, $index);

            if ($type === 'wp') {
                $ids = array_values(array_filter($ids, fn ($id) => $websites[$id]->technology === 'wordpress'));
            }

            if (count($ids) === 0) {
                $items[] = $this->item($lines, $key, 'not_found', null, null, [], $type === 'wp' ? 'No WordPress website matches this domain.' : 'No website matches this domain.');
                continue;
            }

            if (count($ids) > 1) {
                $items[] = $this->item($lines, $key, 'ambiguous', null, null, [], 'Matches websites ' . implode(', ', array_map(fn ($id) => '#' . $id, $ids)) . '.');
                continue;
            }

            $candidates[$key] = [
                'id'     => $ids[0],
                'lines'  => $lines,
                'values' => $merged,
                'merged' => count($group) > 1,
            ];
        }

        $claims = array_count_values(array_column($candidates, 'id'));

        foreach ($candidates as $key => $candidate) {
            $website = $websites[$candidate['id']];

            if ($claims[$candidate['id']] > 1) {
                $items[] = $this->item($candidate['lines'], $key, 'ambiguous', $website->id, $website->site_name, [], 'Another domain in the file maps to the same website #' . $website->id . '.');
                continue;
            }

            [$changes, $reencrypt] = $this->computeChanges($website, $candidate['values'], $type);

            $notes = [];

            if ($candidate['merged']) {
                $notes[] = 'Duplicate rows merged.';
            }

            if ($reencrypt) {
                $notes[] = 'Existing value stored unencrypted; will be encrypted.';
            }

            $items[] = $this->item(
                $candidate['lines'],
                $key,
                $changes ? 'update' : 'unchanged',
                $website->id,
                $website->site_name,
                $changes,
                implode(' ', $notes)
            );
        }

        usort($items, fn ($a, $b) => min($a['lines']) <=> min($b['lines']));

        $summary = ['total' => count($items), 'update' => 0, 'unchanged' => 0, 'not_found' => 0, 'conflict' => 0, 'ambiguous' => 0, 'invalid' => 0, 'no_data' => 0];

        foreach ($items as $item) {
            $summary[$item['status']]++;
        }

        return ['items' => $items, 'summary' => $summary];
    }

    public function applyChanges(int $websiteId, array $changes): array
    {
        $allowed = array_merge(self::FIELDS, self::WP_FIELDS);

        try {
            return DB::transaction(function () use ($websiteId, $changes, $allowed) {
                $website = Website::lockForUpdate()->find($websiteId);

                if (!$website) {
                    throw new RuntimeException('Website no longer exists.');
                }

                $applied = [];

                foreach ($changes as $field => $value) {
                    if (!in_array($field, $allowed, true)) {
                        continue;
                    }

                    $needsUpdate = (string) $website->{$field} !== (string) $value;

                    if (!$needsUpdate && in_array($field, self::ENCRYPTED_FIELDS, true)) {
                        $needsUpdate = !$this->isEncrypted($website->getRawOriginal($field));
                    }

                    if ($needsUpdate) {
                        $website->{$field} = $value;
                        $applied[] = $field;
                    }
                }

                if (!$applied) {
                    return ['status' => 'unchanged', 'site_name' => $website->site_name, 'fields' => [], 'message' => ''];
                }

                $website->save();

                $fresh = Website::find($websiteId);

                foreach ($applied as $field) {
                    if (in_array($field, self::ENCRYPTED_FIELDS, true)) {
                        $raw = $fresh->getRawOriginal($field);

                        if (!$this->isEncrypted($raw) || Crypt::decryptString((string) $raw) !== (string) $changes[$field]) {
                            throw new RuntimeException('Encryption verification failed for ' . $field . '.');
                        }
                    } elseif ((string) $fresh->{$field} !== (string) $changes[$field]) {
                        throw new RuntimeException('Verification failed for ' . $field . '.');
                    }
                }

                return ['status' => 'updated', 'site_name' => $website->site_name, 'fields' => $applied, 'message' => 'Saved, encrypted and verified.'];
            });
        } catch (Throwable $e) {
            Log::error('Website credential import failed', ['website_id' => $websiteId, 'error' => $e instanceof RuntimeException ? $e->getMessage() : get_class($e)]);

            return [
                'status'    => 'failed',
                'site_name' => null,
                'fields'    => [],
                'message'   => $e instanceof RuntimeException ? $e->getMessage() : 'Update failed and was rolled back. Check the application log.',
            ];
        }
    }

    public function normalizeDomain(?string $value): string
    {
        $value = strtolower(trim((string) $value));

        if ($value === '') {
            return '';
        }

        $value = preg_replace('#^[a-z][a-z0-9+.\-]*://#', '', $value);
        $value = preg_split('#[/?\#\s]#', $value)[0] ?? '';
        $value = preg_replace('#^[^@]*@#', '', $value);
        $value = preg_replace('#:\d+$#', '', $value);
        $value = preg_replace('#^www\.#', '', $value);

        return rtrim($value, '.');
    }

    private function fieldsFor(string $type): array
    {
        return $type === 'wp' ? self::WP_FIELDS : self::FIELDS;
    }

    private function headersFor(string $type): array
    {
        return $type === 'wp' ? self::WP_HEADERS : self::HEADERS;
    }

    private function readSpreadsheet(UploadedFile $file): array
    {
        $sheets = Excel::toArray(new RawSheetImport, $file);

        return $sheets[0] ?? [];
    }

    private function readDelimited(string $path): array
    {
        $content = file_get_contents($path);

        if ($content === false) {
            throw new InvalidArgumentException('The uploaded file could not be read.');
        }

        $content = preg_replace('/^\xEF\xBB\xBF/', '', $content);

        if (!mb_check_encoding($content, 'UTF-8')) {
            $content = mb_convert_encoding($content, 'UTF-8', 'Windows-1252');
        }

        $firstLine = '';

        foreach (preg_split('/\r\n|\r|\n/', $content) as $line) {
            if (trim($line) !== '') {
                $firstLine = $line;
                break;
            }
        }

        $delimiter = ',';
        $highest = 0;

        foreach (["\t", ',', ';', '|'] as $candidate) {
            $count = substr_count($firstLine, $candidate);

            if ($count > $highest) {
                $highest = $count;
                $delimiter = $candidate;
            }
        }

        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $content);
        rewind($stream);

        $matrix = [];

        while (($row = fgetcsv($stream, 0, $delimiter, '"', '')) !== false) {
            $matrix[] = $row;
        }

        fclose($stream);

        return $matrix;
    }

    private function rowsFromMatrix(array $matrix, string $type): array
    {
        $headerIndex = null;

        foreach ($matrix as $i => $row) {
            if (!$this->isBlankRow($row)) {
                $headerIndex = $i;
                break;
            }
        }

        if ($headerIndex === null) {
            throw new InvalidArgumentException('The file is empty.');
        }

        $fields = $this->fieldsFor($type);
        $map = [];

        foreach ($matrix[$headerIndex] as $column => $heading) {
            $key = preg_replace('/[^a-z0-9]/', '', strtolower((string) $heading));

            foreach ($this->headersFor($type) as $field => $aliases) {
                if (in_array($key, $aliases, true) && !isset($map[$field])) {
                    $map[$field] = $column;
                }
            }
        }

        if (!isset($map['domain'])) {
            throw new InvalidArgumentException('Column "domain" was not found in the header row.');
        }

        if (!array_intersect_key($map, array_flip($fields))) {
            throw new InvalidArgumentException($type === 'wp'
                ? 'No key columns found. Expected: consumer_key, consumer_secret.'
                : 'No credential columns found. Expected: ipaddress, dbname, username, password, port.');
        }

        $rows = [];

        for ($i = $headerIndex + 1, $count = count($matrix); $i < $count; $i++) {
            $row = $matrix[$i];

            if ($this->isBlankRow($row)) {
                continue;
            }

            $entry = ['line' => $i + 1, 'domain' => trim((string) ($row[$map['domain']] ?? ''))];

            foreach ($fields as $field) {
                $raw = isset($map[$field]) ? (string) ($row[$map[$field]] ?? '') : '';
                $entry[$field] = $field === 'db_password' ? trim($raw, "\r\n") : trim($raw);
            }

            $rows[] = $entry;
        }

        if (count($rows) > self::MAX_ROWS) {
            throw new InvalidArgumentException('The file has more than ' . self::MAX_ROWS . ' rows.');
        }

        if (!$rows) {
            throw new InvalidArgumentException('The file has a header but no data rows.');
        }

        return $rows;
    }

    private function isBlankRow(array $row): bool
    {
        foreach ($row as $cell) {
            if (trim((string) $cell) !== '') {
                return false;
            }
        }

        return true;
    }

    private function indexWebsites($websites): array
    {
        $byHost = [];
        $byLabel = [];
        $byName = [];

        foreach ($websites as $website) {
            $host = $this->normalizeDomain($website->site_link);

            if ($host !== '') {
                $byHost[$host][] = $website->id;
                $byLabel[explode('.', $host)[0]][] = $website->id;
            }

            $name = $this->normalizeDomain(str_replace(' ', '', (string) $website->site_name));
            $name = preg_replace('/[^a-z0-9.\-]/', '', $name);

            if ($name !== '' && ($host === '' || !str_contains($name, '.'))) {
                $byName[$name][] = $website->id;
            }
        }

        return ['host' => $byHost, 'label' => $byLabel, 'name' => $byName];
    }

    private function matchWebsites(string $domain, array $index): array
    {
        $ids = str_contains($domain, '.')
            ? array_merge($index['host'][$domain] ?? [], $index['name'][$domain] ?? [])
            : array_merge($index['label'][$domain] ?? [], $index['name'][$domain] ?? []);

        return array_values(array_unique($ids));
    }

    private function mergeGroup(array $group, string $type): ?array
    {
        $merged = [];

        foreach ($this->fieldsFor($type) as $field) {
            $values = array_values(array_unique(array_filter(array_column($group, $field), fn ($value) => $value !== '')));

            if (count($values) > 1) {
                return null;
            }

            $merged[$field] = $values[0] ?? '';
        }

        return $merged;
    }

    private function validateValues(array &$values, string $type): ?string
    {
        if ($type === 'wp') {
            foreach (self::WP_FIELDS as $field) {
                if ($values[$field] === '') {
                    continue;
                }

                if (strlen($values[$field]) > 1000) {
                    return $field . ' is longer than 1000 characters.';
                }

                if (preg_match('/\s/', $values[$field])) {
                    return $field . ' contains spaces.';
                }
            }

            if ($values['consumer_key'] !== '' && !str_starts_with($values['consumer_key'], 'ck_')) {
                return 'consumer_key must start with ck_.';
            }

            if ($values['consumer_secret'] !== '' && !str_starts_with($values['consumer_secret'], 'cs_')) {
                return 'consumer_secret must start with cs_.';
            }

            return null;
        }

        foreach (['db_host', 'db_name', 'db_username', 'db_password'] as $field) {
            if (strlen($values[$field]) > 255) {
                return $field . ' is longer than 255 characters.';
            }
        }

        if ($values['db_host'] !== '' && preg_match('/\s/', $values['db_host'])) {
            return 'db_host (ipaddress) contains spaces.';
        }

        if ($values['db_port'] !== '') {
            if (!ctype_digit($values['db_port']) || (int) $values['db_port'] < 1 || (int) $values['db_port'] > 65535) {
                return 'Port must be a number between 1 and 65535.';
            }

            $values['db_port'] = (string) (int) $values['db_port'];
        }

        return null;
    }

    private function computeChanges(Website $website, array $values, string $type): array
    {
        $changes = [];
        $reencrypt = false;

        foreach ($this->fieldsFor($type) as $field) {
            $value = $values[$field];
            $raw = $website->getRawOriginal($field);

            if ($field === 'db_port' && $value === '') {
                if (blank($raw)) {
                    $changes['db_port'] = '3306';
                } elseif (!$this->isEncrypted($raw)) {
                    $changes['db_port'] = (string) $website->db_port;
                    $reencrypt = true;
                }

                continue;
            }

            if ($value === '') {
                continue;
            }

            $sameValue = (string) $website->{$field} === $value;
            $encrypted = $this->isEncrypted($raw);

            if (!$sameValue || !$encrypted) {
                $changes[$field] = $value;
            }

            if ($sameValue && !$encrypted) {
                $reencrypt = true;
            }
        }

        return [$changes, $reencrypt];
    }

    private function isEncrypted($raw): bool
    {
        if ($raw === null || $raw === '') {
            return false;
        }

        try {
            Crypt::decryptString((string) $raw);

            return true;
        } catch (DecryptException $e) {
            return false;
        }
    }

    private function item(array $lines, string $domain, string $status, ?int $websiteId, ?string $siteName, array $changes, string $note): array
    {
        return [
            'lines'      => $lines,
            'domain'     => $domain,
            'status'     => $status,
            'website_id' => $websiteId,
            'site_name'  => $siteName,
            'fields'     => array_keys($changes),
            'changes'    => $changes,
            'note'       => $note,
        ];
    }
}