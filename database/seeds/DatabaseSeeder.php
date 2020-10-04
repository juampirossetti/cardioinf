<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProfessionalsTableSeeder::class);
        $this->call(TimetablesTableSeeder::class);
        $this->call(InsurancesTableSeeder::class);
        //$this->call(AppointmentsTableSeeder::class);
        $this->call(MedicalStudiesTableSeeder::class);
    }
}
