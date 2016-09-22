<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSegmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('segments', function(Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('id_line')->unsigned()->default(0);
            $table->foreign('id_line')->references('id')->on('lines')->onDelete('cascade');
            $table->integer('id_material')->unsigned()->default(0);
            $table->foreign('id_material')->references('id')->on('materials')->onDelete('cascade');
            $table->integer('id_start_point')->unsigned()->default(0);
            $table->foreign('id_start_point')->references('id')->on('points')->onDelete('cascade');
            $table->integer('id_final_point')->unsigned()->default(0);
            $table->foreign('id_final_point')->references('id')->on('points')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('segments');
    }
}
