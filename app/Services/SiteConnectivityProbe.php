<?php

namespace App\Services;

use PDO;
use PDOException;

class SiteConnectivityProbe
{
    private const TCP_TIMEOUT = 5.0;

    private const DB_TIMEOUT = 6;

    public function run(array $sites): array
    {
        $results = [];
        $pending = [];

        foreach ($sites as $site) {
            $missing = $this->missing($site);

            if ($missing !== null) {
                $results[$site['id']] = $this->result($site, 'config', '', $missing, 'Fill the missing value on the website edit page', 0);
                continue;
            }

            $pending[$site['id']] = $site;
        }

        $network = $this->probeTcp($pending);

        foreach ($pending as $id => $site) {
            $tcp = $network[$id];

            if ($tcp['state'] !== 'open') {
                $results[$id] = $this->result($site, 'network', $tcp['errno'] ?: '', $tcp['message'], $tcp['hint'], $tcp['ms']);
                continue;
            }

            $results[$id] = $this->probeDatabase($site, $tcp['ms']);
        }

        ksort($results);

        return array_values($results);
    }

    private function missing(array $site): ?string
    {
        foreach (['host' => 'Database host', 'database' => 'Database name', 'username' => 'Database username', 'password' => 'Database password'] as $key => $label) {
            if ($site[$key] === '') {
                return $label . ' is missing';
            }
        }

        return null;
    }

    private function resolve(string $host): ?string
    {
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            return $host;
        }

        $ip = gethostbyname($host);

        return $ip === $host ? null : $ip;
    }

    private function probeTcp(array $sites): array
    {
        $results = [];
        $sockets = [];
        $owners = [];
        $targets = [];
        $started = microtime(true);

        foreach ($sites as $id => $site) {
            $ip = $this->resolve($site['host']);

            if ($ip === null) {
                $results[$id] = $this->tcpFailure(0, 'Host name could not be resolved', 0);
                continue;
            }

            $targets[$id] = str_contains($ip, ':') ? '[' . $ip . ']' : $ip;
            $socket = @stream_socket_client('tcp://' . $targets[$id] . ':' . $site['port'], $errno, $errstr, 0, STREAM_CLIENT_CONNECT | STREAM_CLIENT_ASYNC_CONNECT);

            if ($socket === false) {
                $results[$id] = $this->tcpFailure((int) $errno, (string) $errstr, 0);
                continue;
            }

            stream_set_blocking($socket, false);
            $sockets[$id] = $socket;
            $owners[(int) $socket] = $id;
        }

        $deadline = $started + self::TCP_TIMEOUT;
        $confirm = [];

        while ($sockets) {
            $remaining = $deadline - microtime(true);

            if ($remaining <= 0) {
                break;
            }

            $read = null;
            $except = null;
            $write = array_values($sockets);
            $ready = @stream_select($read, $write, $except, 0, (int) min(200000, max(1000, $remaining * 1000000)));

            if ($ready === false) {
                break;
            }

            foreach ($write as $socket) {
                $id = $owners[(int) $socket];
                $ms = (int) round((microtime(true) - $started) * 1000);

                if (@stream_socket_get_name($socket, true) !== false) {
                    $results[$id] = ['state' => 'open', 'errno' => 0, 'message' => '', 'hint' => '', 'ms' => $ms];
                } else {
                    $confirm[$id] = $ms;
                }

                fclose($socket);
                unset($sockets[$id]);
            }
        }

        foreach ($sockets as $id => $socket) {
            fclose($socket);
            $results[$id] = [
                'state'   => 'closed',
                'errno'   => 110,
                'message' => 'Connection timed out after ' . (int) self::TCP_TIMEOUT . 's',
                'hint'    => 'Remote firewall is dropping packets from this server. Allow this server IP on that port',
                'ms'      => (int) (self::TCP_TIMEOUT * 1000),
            ];
        }

        foreach ($confirm as $id => $ms) {
            $socket = @fsockopen($targets[$id], $sites[$id]['port'], $errno, $errstr, 2);

            if ($socket !== false) {
                fclose($socket);
                $results[$id] = ['state' => 'open', 'errno' => 0, 'message' => '', 'hint' => '', 'ms' => $ms];
                continue;
            }

            $results[$id] = $this->tcpFailure((int) $errno, (string) $errstr, $ms);
        }

        return $results;
    }

    private function tcpFailure(int $errno, string $errstr, int $ms): array
    {
        $text = strtolower($errstr);

        if ($errno === 111 || str_contains($text, 'refused')) {
            $message = 'Connection refused';
            $hint = 'Nothing is listening on this port. Check the port, or MySQL is stopped or bound to localhost only';
        } elseif ($errno === 113 || str_contains($text, 'no route')) {
            $message = 'No route to host';
            $hint = 'Server is down, offline or the IP is wrong';
        } elseif ($errno === 101 || str_contains($text, 'unreachable')) {
            $message = 'Network is unreachable';
            $hint = 'No network path from this server to that address';
        } elseif ($errno === 110 || str_contains($text, 'timed out')) {
            $message = 'Connection timed out';
            $hint = 'Remote firewall is dropping packets from this server. Allow this server IP on that port';
        } else {
            $message = $errstr !== '' ? trim($errstr) : 'Connection failed';
            $hint = 'Check the host and port';
        }

        return ['state' => 'closed', 'errno' => $errno, 'message' => $message, 'hint' => $hint, 'ms' => $ms];
    }

    private function probeDatabase(array $site, int $tcpMs): array
    {
        $started = microtime(true);

        try {
            $pdo = new PDO(
                'mysql:host=' . $site['host'] . ';port=' . $site['port'] . ';dbname=' . $site['database'],
                $site['username'],
                $site['password'],
                [PDO::ATTR_TIMEOUT => self::DB_TIMEOUT, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
            $pdo->query('SELECT 1');
            $pdo = null;

            return $this->result($site, 'ok', '', 'Connected and logged in', '', $tcpMs + (int) round((microtime(true) - $started) * 1000));
        } catch (PDOException $e) {
            $raw = $e->getMessage();
            $code = preg_match('/\[(\d{4})\]/', $raw, $matches) ? (int) $matches[1] : 0;
            $message = preg_replace('/^SQLSTATE\[[^\]]*\]\s*(\[\d+\]\s*)?/', '', $raw);
            $message = preg_replace("/'[^']*'@/", "'***'@", $message);
            $message = mb_strimwidth(trim($message), 0, 140, '...');

            [$status, $hint] = $this->classify($code);

            return $this->result($site, $status, $code ?: '', $message, $hint, $tcpMs + (int) round((microtime(true) - $started) * 1000));
        }
    }

    private function classify(int $code): array
    {
        return match ($code) {
            1045 => ['auth', 'Wrong username or password, or this user is not allowed from this server IP'],
            1044 => ['auth', 'User has no permission on this database'],
            1130 => ['auth', 'MySQL does not allow this server IP. Grant the user access from this IP'],
            1049 => ['database', 'Database name does not exist on that server'],
            1040 => ['error', 'Too many connections on the database server'],
            1226, 1203 => ['error', 'User connection limit reached'],
            3159 => ['error', 'Server requires a secure (SSL) connection'],
            2002, 2003 => ['network', 'Server not reachable. Check host, port and firewall'],
            2006, 2013 => ['network', 'Connection dropped during login. Check the port and any proxy or firewall in between'],
            default => ['error', 'See the error text'],
        };
    }

    private function result(array $site, string $status, $code, string $message, string $hint, int $ms): array
    {
        return [
            'id'        => $site['id'],
            'site_name' => $site['name'],
            'host'      => $site['host'],
            'port'      => $site['port'],
            'status'    => $status,
            'code'      => $code,
            'message'   => $message,
            'hint'      => $hint,
            'ms'        => $ms,
        ];
    }
}