<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->decimal('urgency_24h_per_page', 10, 2)->nullable()->after('urgency_amount');
            $table->decimal('urgency_12h_per_page', 10, 2)->nullable()->after('urgency_24h_per_page');
            $table->decimal('urgency_24h_per_word', 10, 2)->nullable()->after('urgency_12h_per_page');
            $table->decimal('urgency_12h_per_word', 10, 2)->nullable()->after('urgency_24h_per_word');
        });
    }

    public function down()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'urgency_24h_per_page',
                'urgency_12h_per_page',
                'urgency_24h_per_word',
                'urgency_12h_per_word',
            ]);
        });
    }
};