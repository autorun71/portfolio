<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegionsChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions_channels', function (Blueprint $table) {
            $table->unsignedInteger('region_id');
            $table->unsignedInteger('channel_id');

            $table->foreign('region_id')->references('id')->on('regions')->onDelete('cascade');
            $table->foreign('channel_id')->references('id')->on('channels');

            $table->primary(['region_id', 'channel_id'], 'reg_id_chan_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('regions_channels');
    }
}
