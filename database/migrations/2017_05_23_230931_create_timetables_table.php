<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTimetablesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day')->unsigned();
            $table->integer('turn')->unsigned();
            $table->time('from');
            $table->time('until');
            $table->time('delta');
            $table->integer('professional_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');

            $table->unique(array('day', 'turn', 'professional_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('timetables');
    }
}
