<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->string('std_trans_url')->nullable()->after('site_link');
            $table->string('cert_trans_url')->nullable()->after('std_trans_url');
        });
    }

    public function down()
    {
        Schema::table('websites', function (Blueprint $table) {
            $table->dropColumn(['std_trans_url', 'cert_trans_url']);
        });
    }
};
