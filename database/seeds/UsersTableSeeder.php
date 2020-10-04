<?php

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Patient;
use App\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
        	['name' => 'Admin',
        	 'email' => 'juanpablo@girosit.com',
        	 'password' => bcrypt('awesome'),
             'api_token' => str_random(60)
        	]
        ];

        $secretaries = [
            ['name' => 'Secretary',
             'email' => 'secretary@girosit.com',
             'password' => bcrypt('awesome'),
             'api_token' => str_random(60)
            ],
            ['name' => 'Claudia',
             'email' => 'damai1771@hotmail.com',
             'password' => bcrypt('claudia22'),
             'api_token' => str_random(60)
            ]
        ];
        
        $patients = [
            ['name' => 'Patient',
             'email' => 'patient@girosit.com',
             'password' => bcrypt('awesome'),
             'api_token' => str_random(60)
            ]
        ];

        $patients_profile = [
            ['name' => 'Patient',
             'surname' => 'One',
             'dni' => '12345678'
            ]
        ];


        $role_admin = Role::where('name', 'admin')->first();
        $role_secretary = Role::where('name', 'secretary')->first();
        $role_patient = Role::where('name', 'patient')->first();
        
        foreach($admins as $admin){
            $user_o = User::create($admin);
            $user_o->attachRole($role_admin);
        }

        foreach($secretaries as $secretary){
            $user_o = User::create($secretary);
            $user_o->attachRole($role_secretary);
        }

        foreach($patients as $index => $patient){
            $user_o = User::create($patient);
            $patient_o = Patient::create($patients_profile[$index]);
            
            $user_o->attachRole($role_patient);
            $user_o->patient_id = $patient_o->id;
            $user_o->save();
        }
    }
}
