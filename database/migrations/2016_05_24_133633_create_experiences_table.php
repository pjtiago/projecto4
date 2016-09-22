<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('experiences', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('image_link');
            $table->integer('width');
            $table->integer('heigth');
            $table->integer('scale_px');
            $table->integer('scale_real');
            $table->integer('width_workspace');
            $table->integer('heigth_workspace');
            $table->integer('coord_x_workspace');
            $table->integer('coord_y_workspace');
            $table->timestamps();
            $table->integer('id_project')->unsigned()->default(0);
            $table->foreign('id_project')->references('id')->on('projects')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('experiences');
    }
}
