<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePatientsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('surname', 60);
            $table->string('dni')->unique();
            $table->string('address')->nullable();
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->integer('insurance_id')->unsigned()->nullable();
            $table->string('professional')->nullable();
            $table->string('plan')->nullable();
            $table->string('affiliate_number')->nullable();
            
            $table->timestamps();
            
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
        Schema::drop('patients');
    }
}
