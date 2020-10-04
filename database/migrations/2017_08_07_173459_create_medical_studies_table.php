<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMedicalStudiesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_studies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60)->unique();
            $table->boolean('enabled');
            $table->boolean('patient_enabled');
            $table->string('description')->nullable();
            $table->string('acronym');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('medical_studies');
    }
}
