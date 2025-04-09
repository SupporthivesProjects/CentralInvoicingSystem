<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('websites', function (Blueprint $table) {
        $table->string('site_link')->nullable()->after('site_name');
    });
}

public function down()
{
    Schema::table('websites', function (Blueprint $table) {
        $table->dropColumn('site_link');
    });
}

};
