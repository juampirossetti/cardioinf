<?php

use Illuminate\Database\Seeder;

use App\Models\Professional;

class ProfessionalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professionals = [
            ['name' => 'Carlos',
             'surname' => 'Pastore',
             'internal_id' => 1
            ],          
            ['name' => 'Walter',
             'surname' => 'Weidman',
             'internal_id' => 2
            ],
            ['name' => 'Enzo',
             'surname' => 'Pastore',
             'internal_id' => 3
            ],
            ['name' => 'Costanza',
             'surname' => 'Pastore',
             'internal_id' => 4
            ],
            ['name' => 'Turnos Viernes',
             'surname' => '(Sólamente Ecocardiograma Doppler Color Fetal o Cardíaco)',
             'internal_id' => 5
            ]

        ];

        foreach($professionals as $professional) {
            Professional::create($professional);
        }
    }
}
