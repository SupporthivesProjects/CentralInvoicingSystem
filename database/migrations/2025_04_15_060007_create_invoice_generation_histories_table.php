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
        Schema::create('invoice_generation_histories', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');      
            $table->unsignedBigInteger('site_id');
            $table->string('currency')->nullable();
            $table->string('invoice_number');
            $table->json('product_ids')->nullable(); 
            $table->decimal('current_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('invoice_amount', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_generation_histories');
    }
};
