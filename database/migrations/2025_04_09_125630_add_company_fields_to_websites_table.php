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
            $table->string('company_name')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_mobile')->nullable();
            $table->text('company_address')->nullable();
            $table->string('invoice_header_image')->nullable();
            $table->string('invoice_footer_image')->nullable();
            $table->string('invoice_signature')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn([
                'company_name',
                'company_email',
                'company_mobile',
                'company_address',
                'invoice_header_image',
                'invoice_footer_image',
                'invoice_signature',
            ]);
        });
    }
};
