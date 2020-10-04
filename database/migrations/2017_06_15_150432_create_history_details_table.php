<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHistoryDetailsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_details', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date');
            $table->string('description');
            $table->integer('history_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('history_id')->references('id')->on('histories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('history_details');
    }
}
