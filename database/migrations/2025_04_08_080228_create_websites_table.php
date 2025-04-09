<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesTable extends Migration
{
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id(); // Primary key

            $table->unsignedBigInteger('business_model_id'); // Foreign key to BusinessModel
            $table->string('site_name');
            $table->text('site_description')->nullable();
            $table->string('db_host');
            $table->integer('db_port')->default(3306);
            $table->string('db_name');
            $table->string('db_username');
            $table->string('db_password');
            $table->text('remark')->nullable();

            $table->timestamps();

            // Foreign key constraint
            $table->foreign('business_model_id')
                  ->references('id')
                  ->on('business_models')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('websites');
    }
}
