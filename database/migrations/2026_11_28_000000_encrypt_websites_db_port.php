<?php

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE websites MODIFY db_port TEXT NULL');

        DB::transaction(function () {
            foreach (DB::table('websites')->select('id', 'db_port')->get() as $row) {
                $value = $row->db_port;

                if ($value === null || $value === '') {
                    continue;
                }

                try {
                    Crypt::decryptString((string) $value);
                } catch (DecryptException $e) {
                    DB::table('websites')->where('id', $row->id)->update([
                        'db_port' => Crypt::encryptString((string) $value),
                    ]);
                }
            }
        });
    }

    public function down(): void
    {
        DB::transaction(function () {
            foreach (DB::table('websites')->select('id', 'db_port')->get() as $row) {
                $value = $row->db_port;

                if ($value === null || $value === '') {
                    DB::table('websites')->where('id', $row->id)->update(['db_port' => '3306']);
                    continue;
                }

                try {
                    DB::table('websites')->where('id', $row->id)->update([
                        'db_port' => Crypt::decryptString((string) $value),
                    ]);
                } catch (DecryptException $e) {
                }
            }
        });

        DB::statement('ALTER TABLE websites MODIFY db_port INT NOT NULL DEFAULT 3306');
    }
};