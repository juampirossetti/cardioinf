<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfessionalInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('professional_insurance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('professional_id')->unsigned();
            $table->integer('insurance_id')->unsigned();
            $table->string('message')->nullable();
            $table->boolean('enabled_patient')->default(true);
            $table->boolean('enabled_appointment')->default(true);
            $table->timestamps();
            
            $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
            $table->foreign('insurance_id')->references('id')->on('insurances')->onDelete('cascade');
            
            $table->unique(array('professional_id', 'insurance_id'));
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('professional_insurance');
    }
}
