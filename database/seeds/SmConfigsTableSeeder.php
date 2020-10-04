<?php

use Illuminate\Database\Seeder;

use App\Models\SMConfig;

class SmConfigsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $configs = [
            ['key' => 'sitename',
             'value' => 'Cardiología Infantil Santa Fe',
             'section' => 'general'
            ],
            ['key' => 'sitename_part1',
             'value' => 'Cardio',
             'section' => 'general'
            ],
            ['key' => 'sitename_part2',
             'value' => 'INFANTIL',
             'section' => 'general'
            ],
            ['key' => 'sitename_short',
             'value' => 'CI',
             'section' => 'general'
            ],
            ['key' => 'site_description',
             'value' => 'Sistema web de la clínica de cardiología Infantil',
             'section' => 'general'
            ],
            ['key' => 'showmonthsbefore',
             'value' => '12',
             'section' => 'calendar'
            ],
            ['key' => 'showmonthsafter',
             'value' => '12',
             'section' => 'calendar'
            ],
            ['key' => 'max_media_disponibility',
             'value' => '6',
             'section' => 'calendar'
            ],
            ['key' => 'start_hours',
             'value' => '8:00,8:00,8:00,8:00,8:00,8:00,8:00',
             'section' => 'calendar'
            ],
            ['key' => 'end_hours',
             'value' => '22:00,22:00,22:00,22:00,22:00,22:00,22:00',
             'section' => 'calendar'
            ],
            ['key' => 'user_from_login',
             'value' => true,
             'section' => 'patient'
            ],
            ['key' => 'send_reminder',
             'value' => '72',
             'section' => 'patient'
            ],
            ['key' => 'number_of_appointments_in_carousel',
             'value' => '3',
             'section' => 'appointment'
            ],
            ['key' => 'max_appointments_per_professional',
             'value' => '1',
             'section' => 'appointment'
            ],
            ['key' => 'professional_section_enabled',
             'value' => true,
             'section' => 'professional'
            ],
            ['key' => 'max_number_of_professionals',
             'value' => 10,
             'section' => 'professional'
            ]


        ];

        foreach($configs as $config) {
            SMConfig::create($config);
        }
    }
}
