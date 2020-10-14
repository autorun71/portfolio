<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();
            $table->string('text');
            $table->integer('edit_status');
            $table->integer('read_status');
            $table->integer('show_to');
            $table->integer('show_from');
            $table->integer('enable');
            $table->softDeletes();

            $table->foreign('from')->references('id')->on('users');
            $table->foreign('to')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages');
    }
}
