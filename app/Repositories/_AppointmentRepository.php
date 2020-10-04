<?php

namespace App\Repositories;

use App\Models\Appointment;

use InfyOm\Generator\Common\BaseRepository;

use Carbon\Carbon;

use App\Helpers\DatetimeHelper;

class AppointmentRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'insurance',
        'professional_id',
        'patient_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Appointment::class;
    }

    public function getFromNow($professional_id, $status = 0, $start = null, $end = null){
        $today = Carbon::now(-3)->format('Y-m-d');
        $filter_params = [
            'professional_id' => $professional_id,
            'start' => $start != null ? $start : $today,
            'status' => $status
        ];

        $end_date = $end != null ? $end : Carbon::now(-3)->addMonth()->format('Y-m-d');
        $daterange = DatetimeHelper::createRange($today, $end_date);
        $appointments = $this->filter($filter_params);

        //remove reserved appointments
        // foreach($appointments as $key => $ap){
        //     if ($ap->has('reservation')){
        //         $appointments->pull($key);
        //     }
        // }
        //remove duplicate appointments (same date and time)
        $appointments = $appointments->unique(function ($item) {
            return $item['date'].$item['time'];
        });
        
        foreach($daterange as $date) {
            
            if(!array_key_exists($date->format('Y-m-d'), $appointments->groupBy('date')->all())) {
                $el = new Appointment();
                $el->date = $date->format('Y-m-d'); 
                $appointments->push($el);
            }
        }        

        //empty days have a unique appointment with no id
        return $appointments->groupBy('date');
    }

    public function filter(array $filters, $only = null) {

        $appointment = (new Appointment)->newQuery();

        //professional id
        if (array_key_exists('professional_id', $filters)) {
            //@CARDIOINFANTIL
            //agregar turnos de viernes a Pastore Carlos y Pastore Enzo
            // 1: Carlos Pastores, 3: Enzo Pastore, 5: Turnos de viernes
            if($filters['professional_id'] == 1 || $filters['professional_id'] == 3){ 
               $appointment->whereIn('professional_id', array($filters['professional_id'],5));    
            } else {
                $appointment->where('professional_id', $filters['professional_id']);
            }
            //@END
        }

        //start date
        if (array_key_exists('start', $filters)) {
            $appointment->where('date', '>=', $filters['start']);
        }

        //end date
        if (array_key_exists('end', $filters)) {
            $appointment->where('date', '<', $filters['end']);
        }

        //status
        if (array_key_exists('status', $filters)) {
            $appointment->where('status', $filters['status']);
        }

        if($only != null){
            $appointment->select($only);
        }
        
        $appointments = $appointment->orderBy('time','asc')->get();
        
        if(array_key_exists('medical_study_id', $filters) && $filters['medical_study_id'] != null){
            $appointments = $this->filterByMedicalStudy($appointments, $filters['medical_study_id'], false);
        }
        
        return $appointments;
    }

    public function setFree($id){

        $appointment = $this->findWithoutFail($id);
        
        if($appointment != null){
            $data = [
                'patient_id' => null,
                'insurance_id' => null,
                'medical_study_id' => null,
                'money' => null,
                'coupons' => null,
                'status' => 0,
                'comment' => null,
                'patient_name' => null,
                'patient_surname' => null,
                'patient_address' => null,
                'patient_primary_phone' => null,
                'patient_secondary_phone' => null,
                'patient_plan' => null,
                'patient_affiliate_number' => null,
                'patient_professional' => null,
                'patient_email' => null,
                'user_id' => null
                ];
            $this->update($data,$id);
        }
    }

    public function filterByMedicalStudy($appointments, $medical_study_id, $use_time = true){
        foreach ($appointments as $key => $appointment) {
            $professional = $appointment->professional;
            if($use_time){
                if(!$professional->does($medical_study_id, $appointment->date, $appointment->time)) {
                    $appointments->pull($key);
                }
            } else {
                if(!$professional->does($medical_study_id, $appointment->date)) {
                    $appointments->pull($key);
                }
            }

        }

        return $appointments->values();
    }

    public function findByDni($dni){
        $appointments = Appointment::where('patient_dni', 'like', '%' . $dni . '%')->get();

        return $appointments;
    }

    public function findByNameAndSurname($name, $surname){

        $appointments = Appointment::query();
        if($name !== null && $name != ''){
            $appointments->where('patient_name', 'like', '%' . $name . '%');
        }
        if($surname !== null && $surname != ''){
            $appointments->where('patient_surname', 'like', '%' . $surname . '%');
        }
        
        $appointments->orderBy('date','DESC');

        return $appointments->get();
    }
}
