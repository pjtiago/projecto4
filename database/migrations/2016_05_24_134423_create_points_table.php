<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('coord_x');
            $table->integer('coord_y');
            $table->timestamps();
            $table->integer('id_line')->unsigned()->default(0);
            $table->foreign('id_line')->references('id')->on('lines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('points');
    }
}
