<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 20);
            $table->integer('parent_id')->unsigned()->index();
            // or you can use those
            // $table->integer('commentable_id')->unsigned()->index();
            // $table->string('commentable_type')->index();
            $table->integer('user_id')->unsigned()->index();
            $table->string('url', 255);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('images');
    }
}
