<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PDO;
use Throwable;

class WebsiteConnectivityController extends Controller
{
    private const CONNECTION = 'remote_site_check';

    private const TIMEOUT = 5;

    public function check(Request $request): JsonResponse
    {
        if (!auth()->user()->roles->contains('name', 'developer')) {
            abort(403);
        }

        $request->validate([
            'website_id'  => 'nullable|exists:websites,id',
            'db_host'     => 'nullable|string|max:255',
            'db_port'     => 'nullable|integer|min:1|max:65535',
            'db_name'     => 'nullable|string|max:255',
            'db_username' => 'nullable|string|max:255',
            'db_password' => 'nullable|string|max:255',
        ]);

        $website = $request->filled('website_id') ? Website::find($request->input('website_id')) : null;

        $value = function (string $field) use ($request, $website) {
            if ($request->filled($field)) {
                return (string) $request->input($field);
            }

            return $website ? $website->{$field} : null;
        };

        $host = trim((string) $value('db_host'));
        $port = (int) ($value('db_port') ?: 3306);
        $database = trim((string) $value('db_name'));
        $username = trim((string) $value('db_username'));
        $password = (string) $value('db_password');
        $target = $host . ':' . $port;
        $started = microtime(true);

        foreach (['Database host' => $host, 'Database name' => $database, 'Database username' => $username, 'Database password' => $password] as $label => $item) {
            if ($item === '') {
                return $this->respond(false, 'config', $label . ' is missing. Enter it here or save it on this website first.', '', $started);
            }
        }

        if (strcasecmp($host, 'localhost') !== 0) {
            $probeHost = filter_var($host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? '[' . $host . ']' : $host;
            $socket = @fsockopen($probeHost, $port, $errno, $errstr, self::TIMEOUT);

            if ($socket === false) {
                Log::warning('Remote DB check: network failure', ['website_id' => $website?->id, 'target' => $target, 'error' => $errstr]);

                return $this->respond(false, 'network', $this->describeSocketFailure((string) $errstr, $host, $port), $target, $started);
            }

            fclose($socket);
        }

        Config::set('database.connections.' . self::CONNECTION, [
            'driver'    => 'mysql',
            'host'      => $host,
            'port'      => $port,
            'database'  => $database,
            'username'  => $username,
            'password'  => $password,
            'charset'   => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'    => '',
            'strict'    => true,
            'engine'    => null,
            'options'   => [PDO::ATTR_TIMEOUT => self::TIMEOUT],
        ]);

        DB::purge(self::CONNECTION);

        try {
            DB::connection(self::CONNECTION)->getPdo();
            DB::connection(self::CONNECTION)->select('select 1');
            DB::purge(self::CONNECTION);

            return $this->respond(true, 'ok', 'Connection successful. The credentials are valid.', $target, $started);
        } catch (Throwable $e) {
            DB::purge(self::CONNECTION);

            [$stage, $message, $clientIp, $code] = $this->describeDatabaseFailure($e);

            Log::warning('Remote DB check: database failure', ['website_id' => $website?->id, 'target' => $target, 'stage' => $stage, 'code' => $code]);

            return $this->respond(false, $stage, $message, $target, $started, $clientIp);
        }
    }

    private function respond(bool $success, string $stage, string $message, string $target, float $started, ?string $clientIp = null): JsonResponse
    {
        return response()->json([
            'success'    => $success,
            'stage'      => $stage,
            'message'    => $message,
            'target'     => $target,
            'elapsed_ms' => (int) round((microtime(true) - $started) * 1000),
            'client_ip'  => $clientIp,
        ]);
    }

    private function describeSocketFailure(string $error, string $host, int $port): string
    {
        $error = strtolower($error);

        if (str_contains($error, 'refused')) {
            return 'Connection refused by ' . $host . ':' . $port . '. MySQL is not listening on this port, or that server\'s firewall is rejecting this server. Check the port and allow this server\'s IP address.';
        }

        if (str_contains($error, 'timed out') || str_contains($error, 'timeout')) {
            return 'Connection to ' . $host . ':' . $port . ' timed out. A firewall is most likely dropping packets from this server. Allow this server\'s IP address on that port.';
        }

        if (str_contains($error, 'getaddrinfo') || str_contains($error, 'name or service')) {
            return 'The host "' . $host . '" could not be resolved. Check the host name.';
        }

        if (str_contains($error, 'unreachable')) {
            return 'There is no route to ' . $host . '. Check the host address.';
        }

        return 'Could not reach ' . $host . ':' . $port . '. Check the host and port.';
    }

    private function describeDatabaseFailure(Throwable $e): array
    {
        $raw = $e->getMessage();
        $code = preg_match('/\[(\d{4})\]/', $raw, $matches) ? (int) $matches[1] : 0;

        $clientIp = null;

        if (in_array($code, [1045, 1044, 1130], true)) {
            if (preg_match("/'[^']*'@'([^']+)'/", $raw, $found)) {
                $clientIp = $found[1];
            } elseif (preg_match("/Host '([^']+)' is not allowed/", $raw, $found)) {
                $clientIp = $found[1];
            }
        }

        $map = [
            1045 => ['auth', 'Access denied. The username or password is wrong, or this user is not allowed to connect from this server.'],
            1044 => ['auth', 'The user has no permission to use this database.'],
            1130 => ['auth', 'The MySQL server does not allow connections from this server. Grant the user access from this server\'s IP address.'],
            1049 => ['database', 'The database name was not found on that server.'],
            2002 => ['network', 'The database server could not be reached. Check the host and port.'],
            2003 => ['network', 'Could not connect to the database server. Check the host, the port and the firewall.'],
            2006 => ['network', 'The database server closed the connection.'],
            2013 => ['network', 'The connection was lost while connecting. Check the port and any firewall or proxy in between.'],
        ];

        if (isset($map[$code])) {
            return [$map[$code][0], $map[$code][1], $clientIp, $code];
        }

        return ['error', 'Could not connect to the database. Check the connection details.', null, $code];
    }
}