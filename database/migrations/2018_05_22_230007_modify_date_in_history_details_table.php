<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyDateInHistoryDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('history_details', function (Blueprint $table) {
          $table->dropColumn('date');
        });

        Schema::table('history_details', function (Blueprint $table) {
          $table->dateTime('date')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('history_details', function (Blueprint $table) {
          $table->dropColumn('date');
        });

        Schema::table('history_details', function (Blueprint $table) {
          $table->date('date');
        });
    }
}
