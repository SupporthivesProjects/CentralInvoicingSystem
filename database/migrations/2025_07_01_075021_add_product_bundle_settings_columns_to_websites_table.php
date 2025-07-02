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

            $table->string('product_table')->default('products')->nullable()->after('db_password');
            $table->string('bundle_table')->default('game_sever_based_cost')->nullable()->after('product_table');
            $table->string('general_settings')->default('general_settings')->nullable()->after('bundle_table');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            
           $table->dropColumn([
                'product_table',
                'bundle_table',
                'general_settings',
            ]);
        });
    }
};
