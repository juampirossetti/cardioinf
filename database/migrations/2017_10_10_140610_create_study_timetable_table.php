<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudyTimetableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('study_timetable', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_study_id')->unsigned();
            $table->integer('timetable_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('medical_study_id')->references('id')->on('medical_studies')->onDelete('cascade');
            $table->foreign('timetable_id')->references('id')->on('timetables')->onDelete('cascade');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('study_timetable');
    }
}
