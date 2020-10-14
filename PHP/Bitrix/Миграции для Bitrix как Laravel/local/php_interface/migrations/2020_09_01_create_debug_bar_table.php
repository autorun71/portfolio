<?php

use App\Core\DB\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDebugBarTable extends Migration
{

    function up()
    {
        Schema::create('debug_bar', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('OBJECT');
            $table->string('PARAMS');
            $table->integer('DEBUG_BAR_ID');

        });
    }

    function down()
    {
        Schema::dropIfExists('debug_bar');
    }
}
