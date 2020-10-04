<?php

namespace App\Services\Patient;

use App\Repositories\AppointmentRepository;

use App\Repositories\ProfessionalRepository;

use App\Models\Patient;

use App\Models\Appointment;

use Config;

use Carbon\Carbon;

use App\Services\EmailService;

class PatientAppointmentService
{
    private $appointmentRepository;

    private $emailService;
    
    // private $professionalRepository;

    public function __construct(AppointmentRepository $appointmentRepo, ProfessionalRepository $professionalRepo, EmailService $emailServ){

        $this->appointmentRepository = $appointmentRepo;
        $this->emailService = $emailServ;
        // $this->professionalRepository = $professionalRepo;

    }

    public function saveAppointmentAfterReservation($data, $id){

        $appointment = $this->appointmentRepository->findWithoutFail($id);

        $today = Carbon::now(-3)->format('Y-m-d');

        $other_appointments = Appointment::where('professional_id', $appointment->professional_id)
                                         ->where('patient_id', $data['patient_id'])
                                         ->where('date', ">=", $today)
                                         ->get();

        
        if (empty($appointment) || 
            $appointment->status != Config::get('appointment.status.libre') ||
            ($appointment->reservation != null && $appointment->reservation->patient_id != $data['patient_id'])) {
            return 'error';
        }

        //los datos del paciente no pueden estar vacios
        if(!isset($data['patient_dni']) || !isset($data['patient_name']) || !isset($data['patient_surname'])){
            return 'error';
        }

        if($other_appointments->count() >= Config::get('appointment.max_appointments_per_professional')){
            if($appointment->reservation != null) $appointment->reservation->delete();
            return 'max_appointments_per_professional';
        }  
        
        \DB::beginTransaction();      
        try{
            $patient = null;
            if($data['patient_dni'] !== null && $data['patient_dni'] !== ''){
                $patient = Patient::where('dni', $data['patient_dni'])->first();
                if($patient == null){ //creamos el patient
                    $patientData = [
                        'name' => $data['patient_name'],
                        'surname' => $data['patient_surname'],
                        'dni' => $data['patient_dni']
                    ];
                    $patient = Patient::create($patientData);
                }
            }
        
            if($patient !== null){
                $data['patient_name'] = $patient->name;
                $data['patient_surname'] = $patient->surname;
            }

            $appointment = $this->appointmentRepository->update($data, $id);
            if($patient !== null){
                $appointment->patient_id = $patient->id;
                $appointment->save();
            }
            if($appointment->reservation != null) $appointment->reservation->delete();
            
            \DB::commit();

        } catch(\Exception $e){
            \DB::rollback();
            return 'error';
        }

        $this->emailService->sendInfoMessage($appointment);
        
        return 1;
    }   
}
