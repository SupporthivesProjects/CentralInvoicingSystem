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
            $table->string('invoice_image7')->nullable()->after('invoice_image4');
            $table->string('invoice_image8')->nullable()->after('invoice_image5');
            $table->string('invoice_image9')->nullable()->after('invoice_image6');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn(['invoice_image7', 'invoice_image8', 'invoice_image9']);
        });
    }
};
