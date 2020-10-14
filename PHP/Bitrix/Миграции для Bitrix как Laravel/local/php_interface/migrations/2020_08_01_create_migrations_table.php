<?php

use App\Core\DB\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMigrationsTable extends Migration
{

    function up()
    {
        Schema::create('migrations', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('class');
            $table->timestamps();

        });
    }

    function down()
    {
        Schema::dropIfExists('migration');
    }
}
