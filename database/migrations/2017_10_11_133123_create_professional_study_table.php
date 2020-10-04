<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalStudyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_study', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('professional_id')->unsigned();
            $table->integer('medical_study_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->foreign('medical_study_id')->references('id')->on('medical_studies')->onDelete('cascade');
            
            $table->unique(array('professional_id', 'medical_study_id'));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('professional_study');
    }
}
