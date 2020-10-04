<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAppointmentsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->time('time');
            $table->float('money')->nullable();
            $table->integer('coupons')->nullable();
            $table->integer('insurance_id')->unsigned()->nullable();
            $table->integer('medical_study_id')->unsigned()->nullable();
            $table->integer('status')->unsigned();
            $table->string('comment')->nullable();
            $table->integer('professional_id')->unsigned();
            $table->integer('patient_id')->unsigned()->nullable();

            /* Campos para pacientes sin registro */
            $table->string('patient_name')->nullable();
            $table->string('patient_surname')->nullable();
            $table->string('patient_address')->nullable();
            $table->string('patient_primary_phone')->nullable();
            $table->string('patient_secondary_phone')->nullable();
            $table->string('patient_plan')->nullable();
            $table->string('patient_affiliate_number')->nullable();
            $table->string('patient_professional')->nullable();
            $table->string('patient_email')->nullable();


            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');
            $table->foreign('medical_study_id')->references('id')->on('medical_studies')->onDelete('set null');
            $table->foreign('insurance_id')->references('id')->on('insurances')->onDelete('set null');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appointments');
    }
}
