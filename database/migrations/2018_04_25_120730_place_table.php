<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PlaceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('places',function (Blueprint $table){
           $table->increments('id');
           $table->string('name');
           $table->string('picture');
           $table->string('reference');

           $table->integer('owner_id')->unsigned();
           $table->foreign('owner_id')
               ->references('id')->on('owners')
               ->onDelete('cascade');

           $table->integer('geolocation_id')->unsigned();
           $table->foreign('geolocation_id')
               ->references('id')
               ->on('geolocations')
               ->onDelete('cascade');

           $table->integer('district_id')->unsigned();
           $table->foreign('district_id')
               ->references('id')
               ->on('districts')
               ->onDelete('cascade');
       });

       Schema::create('places_events',function (Blueprint $table){
           $table->increments('id');
           $table->integer('place_id')->unsigned();

           $table->foreign('place_id')
               ->references('id')->on('places')
               ->onDelete('cascade');

           $table->integer('event_id')->unsigned();
           $table->foreign('event_id')
               ->references('id')->on('events')
               ->onDelete('cascade');

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
        Schema::dropIfExists('places_events');
        Schema::dropIfExists('places');
    }
}
