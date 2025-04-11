<?php 
namespace App\Services;

use Illuminate\Support\Facades\DB;

class DynamicDatabaseService
{
    public static function connect($site)
    {
        $dynamicDbConfig = [
            'driver' => 'mysql',
            'host' => trim($site->db_host),
            'port' => trim($site->db_port),
            'database' => trim($site->db_name),
            'username' => trim($site->db_username),
            'password' => trim($site->db_password),
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
