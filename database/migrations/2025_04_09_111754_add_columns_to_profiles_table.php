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
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('bio')->nullable();
            $table->string('experience')->nullable();
            $table->string('location')->nullable();
            $table->string('mobile')->nullable();
            $table->string('slack')->nullable();
            $table->string('portfolio')->nullable();
            $table->string('profile_image')->nullable(); // uploads/profiles/profilephoto/<user_id>/
            $table->string('cover_image')->nullable();   // uploads/profiles/coverphoto/<user_id>/
            $table->string('github')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn([
                'user_id', 'bio', 'experience', 'location', 'mobile',
                'slack', 'portfolio', 'profile_image', 'cover_image',
                'github', 'twitter', 'linkedin'
            ]);
        });
    }
};
