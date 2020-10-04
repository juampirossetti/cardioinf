<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histories', function (Blueprint $table) {
          $table->string('ultima_visita', 255)->nullable()->after('patient_surname');
          $table->string('domicilio', 255)->nullable()->after('patient_surname');
          $table->string('edad', 255)->nullable()->after('patient_surname');
          $table->string('telefono', 255)->nullable()->after('patient_surname');
          $table->string('medico_cabecera', 255)->nullable()->after('patient_surname');
          $table->string('dni', 255)->nullable()->after('patient_surname');
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
          $table->dropColumn('ultima_visita');
          $table->dropColumn('domicilio');
          $table->dropColumn('edad');
          $table->dropColumn('telefono');
          $table->dropColumn('medico_cabecera');
          $table->dropColumn('dni');
        });
    }
}
