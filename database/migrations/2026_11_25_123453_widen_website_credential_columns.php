<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $columns = [
        'db_host',
        'db_name',
        'db_username',
        'db_password',
        'consumer_key',
        'consumer_secret',
    ];

    public function up(): void
    {
        foreach ($this->columns as $column) {
            if (Schema::hasColumn('websites', $column)) {
                DB::statement("ALTER TABLE websites MODIFY {$column} TEXT NULL");
            }
        }
    }

    public function down(): void
    {
    }
};