<?php

namespace App\Http\Controllers;

use App\Services\WebsiteCredentialImporter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

class WebsiteCredentialImportController extends Controller
{
    private const DIRECTORY = 'credential-imports';

    private const BATCH_SIZE = 10;

    private const TTL_SECONDS = 3600;

    public function preview(Request $request, WebsiteCredentialImporter $importer): JsonResponse
    {
        $this->authorizeDeveloper();

        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls|max:5120',
            'type' => 'nullable|in:db,wp',
        ], [
            'file.mimes' => 'Upload a .csv, .xlsx or .xls file.',
            'file.max'   => 'The file must not exceed 5MB.',
        ]);

        $type = $request->input('type') === 'wp' ? 'wp' : 'db';

        try {
            $rows = $importer->parse($request->file('file'), $type);
        } catch (InvalidArgumentException $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        } catch (Throwable $e) {
            Log::error('Website credential file parse failed: ' . get_class($e));

            return response()->json(['success' => false, 'message' => 'The file could not be read. Check the format and try again.'], 422);
        }

        $plan = $importer->buildPlan($rows, $type);

        $this->purgeStale();

        $token = Str::random(40);

        $this->store($token, [
            'user_id' => auth()->id(),
            'type'    => $type,
            'items'   => $plan['items'],
        ]);

        return response()->json([
            'success' => true,
            'token'   => $token,
            'summary' => $plan['summary'],
            'rows'    => array_map(fn ($item) => [
                'lines'      => $item['lines'],
                'domain'     => $item['domain'],
                'status'     => $item['status'],
                'website_id' => $item['website_id'],
                'site_name'  => $item['site_name'],
                'fields'     => $item['fields'],
                'note'       => $item['note'],
            ], $plan['items']),
        ]);
    }

    public function apply(Request $request, WebsiteCredentialImporter $importer): JsonResponse
    {
        $this->authorizeDeveloper();

        $data = $request->validate([
            'token'  => ['required', 'regex:/^[A-Za-z0-9]{40}$/'],
            'offset' => 'required|integer|min:0',
        ]);

        $plan = $this->load($data['token']);

        if (!$plan) {
            return response()->json(['success' => false, 'message' => 'Import session expired. Upload the file again.'], 410);
        }

        $actionable = array_values(array_filter($plan['items'], fn ($item) => $item['status'] === 'update'));
        $batch = array_slice($actionable, (int) $data['offset'], self::BATCH_SIZE);

        $results = [];

        foreach ($batch as $item) {
            $result = $importer->applyChanges((int) $item['website_id'], $item['changes']);

            $results[] = [
                'domain'     => $item['domain'],
                'website_id' => $item['website_id'],
                'site_name'  => $result['site_name'] ?? $item['site_name'],
                'status'     => $result['status'],
                'fields'     => $result['fields'] ?? [],
                'message'    => $result['message'] ?? '',
            ];
        }

        $processed = (int) $data['offset'] + count($batch);
        $total = count($actionable);
        $done = $processed >= $total;

        if ($done) {
            $this->forget($data['token']);
        }

        return response()->json([
            'success'   => true,
            'processed' => $processed,
            'total'     => $total,
            'done'      => $done,
            'results'   => $results,
        ]);
    }

    public function cancel(Request $request): JsonResponse
    {
        $this->authorizeDeveloper();

        $data = $request->validate([
            'token' => ['required', 'regex:/^[A-Za-z0-9]{40}$/'],
        ]);

        if ($this->load($data['token'])) {
            $this->forget($data['token']);
        }

        return response()->json(['success' => true]);
    }

    private function authorizeDeveloper(): void
    {
        if (!auth()->user()->roles->contains('name', 'developer')) {
            abort(403);
        }
    }

    private function path(string $token): string
    {
        return self::DIRECTORY . '/' . $token . '.enc';
    }

    private function store(string $token, array $payload): void
    {
        Storage::disk('local')->put($this->path($token), Crypt::encryptString(json_encode($payload)));
    }

    private function load(string $token): ?array
    {
        $disk = Storage::disk('local');

        if (!$disk->exists($this->path($token))) {
            return null;
        }

        try {
            $payload = json_decode(Crypt::decryptString($disk->get($this->path($token))), true);
        } catch (Throwable $e) {
            return null;
        }

        if (!is_array($payload) || ($payload['user_id'] ?? null) !== auth()->id()) {
            return null;
        }

        return $payload;
    }

    private function forget(string $token): void
    {
        Storage::disk('local')->delete($this->path($token));
    }

    private function purgeStale(): void
    {
        $disk = Storage::disk('local');

        foreach ($disk->files(self::DIRECTORY) as $file) {
            if ($disk->lastModified($file) < time() - self::TTL_SECONDS) {
                $disk->delete($file);
            }
        }
    }
}