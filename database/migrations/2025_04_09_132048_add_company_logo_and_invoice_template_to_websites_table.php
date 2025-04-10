<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->string('company_logo')->nullable()->after('company_address');
            $table->string('invoice_template')->nullable()->after('invoice_signature');
        });
    }
    
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn('company_logo');
            $table->dropColumn('invoice_template');
        });
    }
};
