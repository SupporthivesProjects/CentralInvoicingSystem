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
        Schema::table('product_price_histories', function (Blueprint $table) {
            $table->decimal('unit_price', 10, 2)->after('product_id');
        });
    }

    /**
     * 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_price_histories', function (Blueprint $table) {
            $table->dropColumn('unit_price');
        });
    }
};
