<?php

use Illuminate\Database\Seeder;

use App\Models\MedicalStudy;

class MedicalStudiesTableSeeder extends Seeder
{

    public $medicalStudies = [
        ['Ecocardiograma Doppler Color Pediatrico','EDP'],
        ['Ecocardiograma Doppler Color Fetal','EDF'],
        ['Electrocardiograma + Consulta (prequirurgico)','ECP'],
        ['Electrocardiograma + Consulta','EC']
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $medicalStudies = $this->medicalStudies;

        foreach($medicalStudies as $ms){
            $medical = MedicalStudy::create([
                'name' => $ms[0],
                'enabled' => 1,
                'patient_enabled' => 1,
                'acronym' => $ms[1]
            ]);
        }
    }
}