<?php

use Illuminate\Database\Seeder;

use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Administrador'; // optional
        $admin->description  = 'Usuario habilitado a modificar la configuración del sistema'; // optional
        $admin->save();
        
        $secretary = new Role();
        $secretary->name         = 'secretary';
        $secretary->display_name = 'Secretaria'; // optional
        $secretary->description  = 'Usuario habilitado para modificar la configuración de los médicos y los turnos'; // optional
        $secretary->save();

        $patient = new Role();
        $patient->name         = 'patient';
        $patient->display_name = 'Paciente'; // optional
        $patient->description  = 'Usuario habilitado a solicitar turnos'; // optional
        $patient->save();

        $professional = new Role();
        $professional->name         = 'professional';
        $professional->display_name = 'Profesional Médico'; // optional
        $professional->description  = 'Usuario habilitado a manejar historias clinicas y ver turnos solicitados'; // optional
        $professional->save();
    }
}
