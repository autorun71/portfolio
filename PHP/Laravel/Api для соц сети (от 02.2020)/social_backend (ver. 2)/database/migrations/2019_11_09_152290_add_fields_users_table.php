<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->integer('main_photo')->nullable()->unsigned();
            $table->string('status')->nullable();
            $table->string('alt_url')->nullable();
            $table->dateTime('birth_day')->nullable();
            $table->integer('sp')->nullable();
            $table->integer('private')->nullable();
            $table->integer('hidden_audio')->nullable();
            $table->integer('message_private')->nullable();
            $table->integer('online')->nullable();
            $table->dateTime('last_online')->nullable();
            $table->softDeletes();

            $table->foreign('main_photo')->references('id')->on('files');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
