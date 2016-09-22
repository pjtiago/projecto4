<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterationExperince2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::table('experiences', function ($table) {
        $table->integer('n_graos');
        $table->float('comprimento_linhas');
        });
        
        Schema::table('segments', function ($table) {
        $table->float('comprimento_segmtento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
