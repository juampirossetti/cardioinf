<?php

namespace App\Services;

use App\Repositories\AppointmentRepository;

use App\Repositories\ProfessionalRepository;

use App\Services\ProfessionalService;

use App\Services\EmailService;

use App\Helpers\TimetableFormatter;

use App\Helpers\DatetimeHelper;

use App\Models\Professional;

use App\Models\MedicalStudy;

use App\Models\Appointment;

use Carbon\Carbon;

use Config;

class AppointmentService
{
    private $appointmentRepository;
    
    private $professionalRepository;

    private $professionalService;

    private $emailService;

    public function __construct(AppointmentRepository $appointmentRepo, ProfessionalRepository $professionalRepo, 
                                ProfessionalService $professionalServ, EmailService $emailServ){

        $this->appointmentRepository = $appointmentRepo;
        $this->professionalRepository = $professionalRepo;
        $this->professionalService = $professionalServ;
        $this->emailService = $emailServ;

    }

    /*
     * Create mass appointments for a range of days for a particular professional
     */
    public function createBulk(array $data) {

        $professional = $this->professionalRepository->find($data['professional_id']);
        
        $timetables = $professional->timetables;
        
        $date_from = $data['date_from'];

        $date_until = $data['date_until'];

        $appointments_per_turn = isset($data['appointments_per_turn']) ? $data['appointments_per_turn'] : 1 ;
        
        return $this->createFromTimetables($professional, $timetables, $date_from, $date_until, $appointments_per_turn);

    }

    /*
     * Create appointments for a range of days for a particular professional.
     */
    private function createFromTimetables($professional, $timetables, $date_from, $date_until, $appointments_per_turn) {

        $new_appointments = 0;

        $timetable_array = array();

        foreach($timetables as $timetable){
            $timetable_array[$timetable->day][] = TimetableFormatter::explodeHours($timetable);
        }

        $daterange = DatetimeHelper::createRange($date_from, $date_until);
        
        foreach($daterange as $date) {
            
            $day_of_week = DatetimeHelper::getDayOfWeek($date);

            if (array_key_exists($day_of_week, $timetable_array)) {
                foreach($timetable_array[$day_of_week] as $timetable_o) {
                    $day = $date->format("Y-m-d");
            
                    $opening_hour = $timetable_o->opening_hour;
                
                    $closing_hour = $timetable_o->closing_hour;  
                
                    $delta_time = $timetable_o->delta_time;
                
                    $new_appointments+= $this->createForADay($professional, $day, $opening_hour, $closing_hour, $delta_time, $appointments_per_turn);
                }
            }
        }
        
        return $new_appointments;
    }

    /*
     * Create appointments for an entire day for a professional.
     */
    private function createForADay($professional, $day, $opening_hour, $closing_hour, $delta_time, $appointments_per_turn)
    {           
        $new_appointments = 0;
        
        /* hours in minutes
         * IMPORTANTE: opening_hour es un array('10','00') => 10:00 am; array('15','20') => 15:20 pm
         * de igual modo es con closing_hour y $delta_time
         */
        $opening_minutes = $opening_hour[0]*60 + $opening_hour[1];
        
        $closing_minutes = $closing_hour[0]*60 + $closing_hour[1];
        
        $delta_minutes = $delta_time[0]*60 + $delta_time[1];
        
        $actual = $opening_minutes;
          
        $data['professional_id'] = $professional->id;
        
        $data['date'] = Carbon::createFromFormat('Y-m-d', $day);
        
        $data['status'] = 0;

        while($actual < $closing_minutes){
            //dd('llego');
            $time = date('H:i', mktime(0,$actual));
            
            $data['time'] = Carbon::createFromFormat('H:i', $time);
            
            for( $i = 0 ; $i<$appointments_per_turn ; $i++){
                $this->appointmentRepository->create($data);
                $new_appointments++;
            }
            
            $actual = $actual + $delta_minutes;
        }

        return $new_appointments;
    }

    public function filterAndGroup($filters, $professional_id, $medical_study_id, $max = 20, $include_reserved = true){

        if($max == null){
            $max = Config::get('appointment.number_of_appointments_in_carousel');
        }

        $start = isset($filters['start']) ? $filters['start'] : null;
        
        $end = isset($filters['end']) ? $filters['end'] : null;
        
        $status = isset($filters['status']) ? $filters['status'] : 0;
        
        $appointments = $this->appointmentRepository->getFromNow($professional_id, $status, $start, $end);

        $professional = $this->professionalRepository->findWithoutFail($professional_id);

        foreach ($appointments as $day=>$appArray) {
            $count = 0;
            foreach($appArray as $ap) {
                if($count < $max){
                    if($include_reserved || !$ap->isReserved){
                        if($ap->id != '' && $professional->does($medical_study_id, $ap->date, $ap->time)) {
                            $result[$ap->date][] = $ap->time;
                            $count++;
                        }
                    }                
                }
            }
            
            if($count == 0) $result[$day] = [];
        }

        ksort($result);
        
        return $result;
    }

    public function multipleFilterAndGroup($filters, $medical_study_id, $max = 20, $include_reserved = true){
        
        $professionals = Professional::where('enabled',1)->get();

        $merged_app = array();
        
        //unimos los turnos de todos los médicos.     
        foreach ($professionals as $profesional){
            
            $appointments = $this->filterAndGroup($filters, $profesional->id, $medical_study_id, $max, $include_reserved);
            
            $merged_app = array_merge_recursive($merged_app, $appointments);
        }

        //ordenamos y eliminamos turnos para que no sobrepasen el $max
        $sorted_app = array();
        
        foreach($merged_app as $k => $array){
            
            sort($array);
            
            $sorted_app[$k] = array_slice($array, 0, $max);
        }
        
        return $sorted_app;
    }

    public function multipleFilterAndGroupWithoutMS($filters, $professional_id, $max = 20, $include_reserved = true){
        
        $medical_studies = MedicalStudy::where('enabled',1)->get();

        $merged_app = array();
        
        //unimos los turnos de todos los médicos.     
        foreach ($medical_studies as $medical_study){
            
            $appointments = $this->filterAndGroup($filters, $professional_id, $medical_study->id, $max, $include_reserved);
            
            $merged_app = array_merge_recursive($merged_app, $appointments);
        }

        //ordenamos y eliminamos turnos para que no sobrepasen el $max
        $sorted_app = array();
        
        foreach($merged_app as $k => $array){
            
            sort($array);
            
            $sorted_app[$k] = array_slice($array, 0, $max);
        }
        
        return $sorted_app;
    }

    public function disponibility($from, $medical_study_id, $professional_id = null) {
        
        $filters['start'] = $from;

        $max_media = Config::get('appointment.max_media_disponibility');

        $max_low = Config::get('appointment.max_low_disponibility');

        $appointments = array();
        
        if($professional_id == null){
            $appointments = $this->multipleFilterAndGroup($filters,$medical_study_id,$max_media+1);
        }else{
            $appointments = $this->filterAndGroup($filters,$professional_id,$medical_study_id,$max_media+1);
        }

        //@CARDIOINFANTIL
        if($medical_study_id == 1 ){//turnos viernes -> solo ecos pediatricos
            $appointments_aux = $this->getFridayAppointments($from, 5, 0, $medical_study_id);
            $appointments = array_merge($appointments, $appointments_aux);
        }
        //@END CARDIOINFANTIL

        $result = array();
        
        $no_app_class = Config::get('appointment.calendar_class.no_appointments_class');
        $low_app_class = Config::get('appointment.calendar_class.low_appointments_class');
        $high_app_class = Config::get('appointment.calendar_class.high_appointments_class');

        //"2017/12/16, Disponibilidad media, media-disponibility",
        foreach($appointments as $date=>$list){
            $formated_date = str_replace('-', '/', $date);
            
            $count = count($list);
            $class = ', Sin Disponibilidad, '.$no_app_class;
            if ($count > $max_media) 
                $class = ', Disponibilidad alta, '.$high_app_class;
            elseif($count != 0) 
                $class = ', Disponibilidad baja, '.$low_app_class;
            
            $result[] = $formated_date.$class;
        }
        
        return $result;
    }

    public function filterProcessingFunction($filters, $professional_id, $medical_study_id){
        $appointments = array();

        if($medical_study_id != null){
            if($professional_id == null){
                $appointments = $this->multipleFilterAndGroup($filters,$medical_study_id, 999);
            }else{
                $appointments = $this->filterAndGroup($filters,$professional_id,$medical_study_id, 999);
            }
        } else {
            if($professional_id != null){
                $appointments = $this->multipleFilterAndGroupWithoutMS($filters, $professional_id, 999);
            }
        }

        return $appointments;
    }

    public function disponibilityExtended($medical_study_id, $professional_id) {
        
        $max_media = Config::get('appointment.max_media_disponibility');

        $max_low = Config::get('appointment.max_low_disponibility');
        
        $appointments = array();

        if($professional_id != null){
            $dates = $this->professionalService->workingDates($professional_id, $medical_study_id);
            $appointments = Appointment::where('professional_id',$professional_id)
                                       ->whereIn('date',$dates)
                                       ->where('status', 0)
                                       ->groupBy('date')
                                       ->select('date', \DB::raw('count(*) as total'), \DB::raw('min(time) as time'))
                                       ->get();
        }
        
        //@CARDIOINFANTIL
        if($professional_id == 1 || $professional_id == 3){//turnos viernes
           $appointments_aux = $this->getFridayAppointments(5, 0, $medical_study_id);
           foreach($appointments_aux as $ap){
                $appointments->push($ap);
           }
        }
        //@END CARDIOINFANTIL

        $result = array();
        
        //$no_app_class = Config::get('appointment.calendar_class.no_appointments_class');
        $low_app_class = Config::get('appointment.calendar_class.low_appointments_class');
        $high_app_class = Config::get('appointment.calendar_class.high_appointments_class');


        //"2017/12/16, Disponibilidad media, media-disponibility",
        foreach($appointments as $item){
            $formated_date = str_replace('-', '/', $item->date);
            
            $count = $item->total;
            $class = ', Sin Disponibilidad, ';
            if ($count > $max_media) 
                $class = ', Libres: '.$count.' - Próximo: '. $item->time.'hs., '.$high_app_class;
            elseif($count != 0) 
                $class = ', Libres: '.$count.' - Próximo: '. $item->time.'hs., '.$low_app_class;
            
            $result[] = $formated_date.$class;
        }
        


        return $result;
    }

    public function disponibilityExtended_2($from, $medical_study_id, $professional_id = null) {
        
        $filters['start'] = $from;

        $appointments = array();
        
        $max_media = Config::get('appointment.max_media_disponibility');

        $max_low = Config::get('appointment.max_low_disponibility');
        
        $appointments = $this->filterProcessingFunction($filters,$professional_id,$medical_study_id);

        //@CARDIOINFANTIL
        if($professional_id == 1 || $professional_id == 3){//turnos viernes
           $appointments_aux = $this->getFridayAppointments($from, 5, 0, $medical_study_id);
           $appointments = array_merge($appointments, $appointments_aux);
        }
        //@END CARDIOINFANTIL

        $result = array();
        
        //$no_app_class = Config::get('appointment.calendar_class.no_appointments_class');
        $low_app_class = Config::get('appointment.calendar_class.low_appointments_class');
        $high_app_class = Config::get('appointment.calendar_class.high_appointments_class');


        //"2017/12/16, Disponibilidad media, media-disponibility",
        foreach($appointments as $date=>$list){
            $formated_date = str_replace('-', '/', $date);
            
            $count = count($list);
            $class = ', Sin Disponibilidad, ';
            if ($count > $max_media) 
                $class = ', Libres: '.$count.' - Próximo: '. $list[0].'hs., '.$high_app_class;
            elseif($count != 0) 
                $class = ', Libres: '.$count.' - Próximo: '. $list[0].'hs., '.$low_app_class;
            
            $result[] = $formated_date.$class;
        }

        return $result;
    }

    public function getFridayAppointments($professional_id, $status, $medical_study_id){
        $monthsafter = Config::get('appointment.calendar.showmonthsafter');
        $to = Carbon::now(-3)->addMonths($monthsafter)->format('Y-m-d');

        $monthsbefore = Config::get('appointment.calendar.showmonthsbefore');
        $from = Carbon::now(-3)->subMonths($monthsbefore)->format('Y-m-d');

        $appointments = array();

        $dates = $this->professionalService->workingDates($professional_id, $medical_study_id);
        
        if($dates != null){
            $appointments = Appointment::where('professional_id', $professional_id)
                                        ->whereIn('date',$dates)
                                        ->where('status', $status)
                                        ->groupBy('date')
                                        ->select('date', \DB::raw('count(*) as total'), \DB::raw('min(time) as time'))
                                        ->get();
        }

        return $appointments;
    }

    public function bulkAction($action, $attributes, $send_email = false){
        $appointments = Appointment::where('professional_id', $attributes['professional_id'])
                                   ->where('date','>=',$attributes['date_from'])
                                   ->where('date','<=',$attributes['date_until'])
                                   ->get();

        if($action == 'disable'){
            $status = Config::get('appointment.status.cancelado');
            $this->bulkChangeStatus($appointments, $status, $send_email);
        }
        if($action == 'delete'){
            $this->bulkDelete($appointments, $send_email);
        }
    }

    public function bulkChangeStatus($appointments, $status, $send_email){
        $occupied_status = Config::get('appointment.status_name.ocupado');
        $cancel_status = Config::get('appointment.status.cancelado');
        foreach($appointments as $a){
            $old_status = $a->status;
            $a->status = $status;
            $a->save();
            if($send_email){
                if($old_status == $occupied_status && $status == $cancel_status){ //Ocupado -> Cancelado
                    $this->emailService->sendDeleteMessage($a, true);
                }
            }
        }
    }

    public function bulkDelete($appointments, $send_email){
        $occupied_status = Config::get('appointment.status.ocupado');
        foreach($appointments as $a){
            $old_status = $a->status;
            if($send_email){
                if($old_status == $occupied_status){ //Libre -> Eliminado
                    $this->emailService->sendDeleteMessage($a);
                }
            }
            $a->delete();
        }   
    }
}