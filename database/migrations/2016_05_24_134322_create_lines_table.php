<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLinesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lines', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('coord_x');
            $table->integer('coord_y');
            $table->double('angle');
            $table->timestamps();
            $table->integer('id_experience')->unsigned()->default(0);
            $table->foreign('id_experience')->references('id')->on('experiences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lines');
    }
}
