<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->decimal('urgency_36_48h_per_page', 10, 4)->nullable()->after('urgency_12h_per_word');
            $table->decimal('urgency_36_48h_per_word', 10, 4)->nullable()->after('urgency_36_48h_per_page');
        });
    }

    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'urgency_36_48h_per_page',
                'urgency_36_48h_per_word',
            ]);
        });
    }
};