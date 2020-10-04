<?php

use Illuminate\Database\Seeder;

use App\Services\AppointmentService;

use App\Models\Professional;

use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    private $appointmentService;

    public function __construct(AppointmentService $appointmentServ){
        $this->appointmentService = $appointmentServ;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$appointmentService = new AppointmentService();

        $professionals = Professional::all();

        foreach($professionals as $professional) {
             $data['professional_id'] = $professional->id;
             $data['date_from'] = Carbon::now()->format('Y-m-d');
             $data['date_until'] = Carbon::now()->addMonth()->format('Y-m-d');
             $data['appointments_per_turn'] = 2;
             $appointments = $this->appointmentService->createBulk($data);
             echo 'Se crearon '.$appointments.' nuevos turnos para el doctor '.$professional->getCompleteName();
        }
    }
}
