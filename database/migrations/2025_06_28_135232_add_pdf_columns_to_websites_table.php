<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->enum('pdf_size', ['A4', 'A5', 'Letter', 'Legal'])
                ->default('A4')
                ->after('bank_code');

            $table->enum('pdf_orientation', ['portrait', 'landscape'])
                ->default('portrait')
                ->after('pdf_size');      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn(['pdf_size', 'pdf_orientation']);
        });
    }
};
