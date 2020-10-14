<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('musics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 150);
            $table->string('artist', 150);
            $table->string('link', 150);
            $table->integer('file')->unsigned();
            $table->integer('author')->unsigned();
            $table->string('duration', 150)->default('-:-');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('author')->references('id')->on('users');
            $table->foreign('file')->references('id')->on('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('musics');
    }
}
