<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EventTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events',function (Blueprint $table){
           $table->increments('id');
           $table->string('title');
           $table->date('start');
           $table->date('end');
           $table->string('picture');
           $table->integer('type_id')->unsigned();
           $table->foreign('type_id')
               ->references('id')->on('types')
               ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
