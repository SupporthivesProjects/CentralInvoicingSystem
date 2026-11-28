<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DynamicDatabaseService
{
    public static function connect($site)
    {
        $dynamicDbConfig = [
            'driver' => 'mysql',
            'host' => trim((string) $site->db_host),
            'port' => (int) ($site->db_port ?: 3306),
            'database' => trim((string) $site->db_name),
            'username' => trim((string) $site->db_username),
            'password' => trim((string) $site->db_password),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ];

        DB::purge('dynamic');
        config(['database.connections.dynamic' => $dynamicDbConfig]);
        DB::reconnect('dynamic');
    }
}