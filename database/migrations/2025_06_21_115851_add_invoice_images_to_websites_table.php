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
            $table->string('invoice_image4')->nullable()->after('invoice_image3');
            $table->string('invoice_image5')->nullable()->after('invoice_image4');
            $table->string('invoice_image6')->nullable()->after('invoice_image5');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn(['invoice_image4', 'invoice_image5', 'invoice_image6']);
        });
    }
};
