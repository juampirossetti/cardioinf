<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('medical_study_id')->unsigned();
            $table->integer('insurance_id')->unsigned()->nullable();
            $table->string('message',1024)->nullable();
            $table->boolean('enabled_appointment')->default(true);
            $table->timestamps();
            
            $table->foreign('medical_study_id')->references('id')->on('medical_studies')->onDelete('cascade');
            $table->foreign('insurance_id')->references('id')->on('insurances')->onDelete('cascade');
            
            $table->unique(array('medical_study_id', 'insurance_id'));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('indications');
    }
}
