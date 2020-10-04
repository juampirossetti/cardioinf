<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMedicalStudiesExceptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exceptions_days', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('professional_id')->unsigned();
            $table->date('date');
            
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            
            $table->unique(array('professional_id','date'));
            
        });

        Schema::create('exceptions_ms', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('exception_day_id')->unsigned();
            $table->integer('medical_study_id')->unsigned();
            
            $table->foreign('exception_day_id')->references('id')->on('exceptions_days')->onDelete('cascade');
            $table->foreign('medical_study_id')->references('id')->on('medical_studies')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('exceptions_ms');
        Schema::drop('exceptions_days');
    }
}
