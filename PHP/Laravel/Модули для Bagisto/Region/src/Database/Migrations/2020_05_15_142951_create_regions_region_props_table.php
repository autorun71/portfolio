<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsRegionPropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions_region_props', function (Blueprint $table) {
//            $table->increments('id');
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('region_props_id');
            $table->unsignedInteger('channels_id');

            $table->string('value');

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('region_props_id')->references('id')->on('region_props')->onDelete('cascade');
            $table->foreign('channels_id')->references('id')->on('channels');

            $table->primary(['region_id','region_props_id', 'channels_id'], 'reg_id_props_id_chan_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions_region_props');
    }
}
