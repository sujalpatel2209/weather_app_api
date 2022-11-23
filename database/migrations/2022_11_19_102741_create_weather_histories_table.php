<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('city_id');
            $table->integer('temp_in_celsius');
            $table->integer('temp_in_fahrenheit');
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_histories');
    }
}
