<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPatientsFieldsToHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histories', function (Blueprint $table) {
          $table->string('patient_name', 255);
          $table->string('patient_surname', 255);
          $table->string('patient_os_number', 255);
          $table->text('comments')->nullable();
          $table->integer('user_id')->unsigned()->nullable();
          $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
          $table->integer('patient_os')->unsigned()->nullable();
          $table->foreign('patient_os')->references('id')->on('insurances')->onDelete('set null');

          $table->dropForeign('histories_patient_id_foreign');
          $table->dropForeign('histories_professional_id_foreign');
          $table->dropUnique(['professional_id','patient_id']);
          
          $table->dropColumn('patient_id');

          $table->integer('professional_id')->unsigned()->nullable()->change();
          $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('histories', function (Blueprint $table) {
          $table->dropForeign('histories_patient_os_foreign');
          $table->dropForeign('histories_user_id_foreign');
          $table->dropForeign('histories_professional_id_foreign');
          
          $table->dropColumn('patient_name');
          $table->dropColumn('patient_surname');
          $table->dropColumn('patient_os');
          $table->dropColumn('patient_os_number');
          $table->dropColumn('comments');
          $table->dropColumn('user_id');

          $table->integer('patient_id')->unsigned()->nullable();
          $table->foreign('patient_id')->references('id')->on('patients')->onDelete('set null');

          $table->foreign('professional_id')->references('id')->on('professionals')->onDelete('cascade');
          $table->unique(array('professional_id', 'patient_id'));

        });
    }
}
