<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Carbon\Carbon;

use Mail;

use Config;

use App\Models\Appointment;


use App\Models\SMConfig;

class SendVouchers extends Command
{
    private $days = [ //    n1               n2                 n3
        /* Lunes */     ['tuesday', 'wednesday' , 'thursday'],
        /* Martes */    ['wednesday', 'thursday', 'friday'],
        /* Miercoles */ ['thursday', 'friday', ['saturday', 'monday']],
        /* Jueves */    [['friday', 'saturday'],['saturday', 'monday'],['sunday', 'tuesday']],
        /* Viernes */   [['sunday', 'monday'],['sunday', 'tuesday'],'wednesday']
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendVouchers:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia los recordatorios N hs antes del turno. N es configurable en la aplicacion.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * Manda recordatorios para los turnos de las proximas 72 hs
     * @return mixed
     */
    public function handle()
    {   

        $hours_before = SMConfig::getByKey('send_reminder');
        $hours_index = ($hours_before / 24) - 1; //0 1 2

        $day_index = Carbon::now(-3)->dayOfWeek;

        if($day_index == 6 || $day_index == 0) return; //sabado y domingo no se mandan recordatorios
        
        $nexts = $this->days[$day_index-1][$hours_index];
        if (is_array($nexts)){
        
            $next_day  = Carbon::parse('next '.$nexts[0])->format('Y-m-d');
            $next_day_2 = Carbon::parse('next '.$nexts[1])->format('Y-m-d');

        } else {
        
            $next_day = Carbon::parse('next '.$nexts)->format('Y-m-d');
            $next_day_2 = null;
        }

        if($next_day != null){
            $this->sendEmails($next_day);
        }        
        
        if($next_day_2 != null) {
            $this->sendEmails($next_day_2);
        }

        return;

    }

    public function sendEmails($date){
        $status = Config::get('appointment.status.ocupado');
        
        $appointments = Appointment::where('date', $date)
                                   ->where('status', $status)
                                   ->get();
        
        foreach($appointments as $ap){
            $email = $ap->getEmail();
            if($email != null && $this->isValidEmail($email)){
                $data = $this->getData($ap);
                
                Mail::queue('pdf.reminder', $data, function ($message) use ($email, $data){
                    $message->from('recordatorios@cardioinfantilsantafe.com', 'Clínica de Cardiología Infantil');

                    $message->to($email, $data['patient_name']);

                    $message->subject('Importante: Recordatorio de turno semanal');
                });
            }
        }
    }

    public function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) 
            && preg_match('/@.+\./', $email);
    }

    public function getData($appointment){
        $data = array();

        $data['date'] = $appointment->date;
        $data['time'] = $appointment->time;
        $data['professional_name'] = isset($appointment->professional) ? $appointment->professional->getCompleteName() : 'No Especifica';
        $data['medical_study_name'] = isset($appointment->medicalStudy) ? $appointment->medicalStudy->name : 'No Especifica';
        $data['patient_name'] = $appointment->getPatientName();

        return $data;

    }
}
