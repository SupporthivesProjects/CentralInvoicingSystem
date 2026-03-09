<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->decimal('urgency_24h_per_page', 10, 4)->nullable()->change();
            $table->decimal('urgency_12h_per_page', 10, 4)->nullable()->change();
            $table->decimal('urgency_24h_per_word', 10, 4)->nullable()->change();
            $table->decimal('urgency_12h_per_word', 10, 4)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->decimal('urgency_24h_per_page', 10, 2)->nullable()->change();
            $table->decimal('urgency_12h_per_page', 10, 2)->nullable()->change();
            $table->decimal('urgency_24h_per_word', 10, 2)->nullable()->change();
            $table->decimal('urgency_12h_per_word', 10, 2)->nullable()->change();
        });
    }
};