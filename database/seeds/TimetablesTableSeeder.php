<?php

use Illuminate\Database\Seeder;

use App\Models\Timetable;

class TimetablesTableSeeder extends Seeder
{	
    /* Profesionales
     * 1: Carlos Pastore, 2: Walter Weidman, 3: Enzo Pastore, 4: Costanza Pastore, 5: Turnos Viernes
     * 
     * 1: Lunes de 16pm a 18.30pm Martes 12 am a 13 am Miercoles 16pm a 18pm Jueves 16pm a 18:30pm
     * 2: Martes de 12am a 9pm y Jueves de 4 pm a 9pm
     * 3: Martes 12am a 9pm Miercoles 16pm a 18pm Jueves 16pm a 18:30pm
     * 4:
     * 5: Viernes de 12am a 13pm y de 13pm a 14.30pm
     */

    private $timetables = [
        [
            'professional_id' => 1,
            'day' =>0,
            'turn' =>1,
            'from' =>'16:00',
            'until' =>'18:30',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 1,
            'day' =>1,
            'turn' =>0,
            'from' =>'12:00',
            'until' =>'13:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 1,
            'day' =>2,
            'turn' =>1,
            'from' =>'16:00',
            'until' =>'18:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 1,
            'day' =>3,
            'turn' =>1,
            'from' =>'16:00',
            'until' =>'18:30',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 2,
            'day' =>1,
            'turn' =>0,
            'from' =>'12:00',
            'until' =>'13:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 2,
            'day' =>1,
            'turn' =>1,
            'from' =>'13:00',
            'until' =>'18:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 2,
            'day' =>3,
            'turn' =>1,
            'from' =>'16:00',
            'until' =>'21:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 3,
            'day' =>1,
            'turn' =>0,
            'from' =>'12:00',
            'until' =>'13:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 3,
            'day' =>1,
            'turn' =>1,
            'from' =>'13:00',
            'until' =>'21:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 3,
            'day' =>2,
            'turn' =>1,
            'from' =>'16:00',
            'until' =>'18:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 3,
            'day' =>3,
            'turn' =>1,
            'from' =>'16:00',
            'until' =>'18:30',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 5,
            'day' =>4,
            'turn' =>0,
            'from' =>'12:00',
            'until' =>'13:00',
            'delta' =>'00:15'
        ],
        [
            'professional_id' => 5,
            'day' =>4,
            'turn' =>1,
            'from' =>'13:00',
            'until' =>'14:30',
            'delta' =>'00:15'
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $professionals = DB::table('professionals')->get();
        // foreach($professionals as $professional){
        //     $days = $this->getDays();
        //     $schedule_1 = factory(App\Models\Timetable::class)->create([
        //         'day' => $days[0],
        //         'professional_id' => $professional->id]);

        //     $schedule_2 = factory(App\Models\Timetable::class)->create([
        //         'day' => $days[1],
        //         'professional_id' => $professional->id]);

        //     $schedule_3 = factory(App\Models\Timetable::class)->create([
        //         'day' => $days[2],
        //         'professional_id' => $professional->id]);

        //     $schedule_4 = factory(App\Models\Timetable::class)->create([
        //         'day' => $days[3],
        //         'professional_id' => $professional->id]);
        // }

        $timetables = $this->timetables;

        foreach($this->timetables as $tt){
            $timetable = Timetable::create($tt);
        }
    }

    public function getDays(){
        
        $days = [0,1,2,3,4];
        
        $keys = array_rand($days,4);
        
        return array_map(function($x) use ($days) { return $days[$x]; }, $keys);
    }
}
