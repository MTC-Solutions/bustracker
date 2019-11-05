<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("origin");
            $table->string("destination");
            $table->boolean("started")->default(false);
            $table->boolean("ended")->default(false);
            $table->string("departureTime");
            $table->bigInteger('bus_id')->unsigned()->nullable();
            $table->foreign("bus_id")->references("id")->on("bus")->onDelete("cascade");
            $table->bigInteger('driver_id')->unsigned()->nullable();
            $table->foreign("driver_id")->references("id")->on("driver")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
