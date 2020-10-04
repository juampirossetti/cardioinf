<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('path');
            $table->string('name');
            
            $table->integer('history_detail_id')->unsigned()->nullable();

            $table->foreign('history_detail_id')->references('id')->on('history_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('detail_files');
    }
}
