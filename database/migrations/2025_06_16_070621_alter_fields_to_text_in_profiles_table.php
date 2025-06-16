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
        Schema::table('profiles', function (Blueprint $table) {
            $table->text('bio')->nullable()->change();
            $table->text('experience')->nullable()->change();
            $table->text('location')->nullable()->change();
            $table->text('slack')->nullable()->change();
            $table->text('portfolio')->nullable()->change();
            $table->text('github')->nullable()->change();
            $table->text('twitter')->nullable()->change();
            $table->text('linkedin')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('bio', 255)->nullable()->change();
            $table->string('experience', 255)->nullable()->change();
            $table->string('location', 255)->nullable()->change();
            $table->string('slack', 255)->nullable()->change();
            $table->string('portfolio', 255)->nullable()->change();
            $table->string('github', 255)->nullable()->change();
            $table->string('twitter', 255)->nullable()->change();
            $table->string('linkedin', 255)->nullable()->change();
        });
    }
};
