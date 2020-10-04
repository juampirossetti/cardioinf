<?php

namespace App\Services;

use App\Repositories\TempReservationRepository;

use App\Repositories\AppointmentRepository;

use App\Models\Appointment;

use App\Models\TempReservation;

use App;

class TempReservationService
{
    private $tempReservationRepository;

    private $appointmentRepository;

    public function __construct(TempReservationRepository $tempReservationRepo,
                                AppointmentRepository $appointmentRepo){
        
        $this->tempReservationRepository = $tempReservationRepo;
        $this->appointmentRepository = $appointmentRepo;

    }

    /*
     * Create mass appointments for a range of days for a particular professional
     */
    public function validateAndCreate(array $data, $patient_id) {
        
        $appointment = Appointment::where('professional_id',$data['professional_id'])
                                   ->where('date',$data['date'])
                                   ->where('time',$data['time'].':00')
                                   ->where('status',0) //que este libre
                                   ->doesnthave('reservation')
                                   ->first();
        
        $reservation = TempReservation::where('patient_id', $patient_id)->first();
        //si no hay más turnos en ese horario se informa y se elimina cualquier otra reserva del paciente
        if($appointment == null){
            if($reservation != null){
                $reservation->delete();
            }
            return (Object) ['status' => false];
        }
        //si no existe una reserva a su nombre la creo
        if($reservation == null){     
            return $this->customCreate($patient_id, $appointment->id);
        }
        //si existe otra reserva a su nombre, se actualiza
        $this->tempReservationRepository->update(['appointment_id' => $appointment->id], $reservation->id);
        
        return (Object) [
            'status' => true,
            'data' => $appointment
        ];

    }

    public function createEmpty($patient_id){
        $reservation = TempReservation::where('patient_id', $patient_id)->first();

        //si existe una reserva vieja, la borro
        if($reservation != null){
            $reservation->delete();
        }
        
        return $this->customCreate($patient_id, null);//creo la nueva reserva vacia
    }

    public function customCreate($patient_id, $appointment_id) {
        $data = [
            'patient_id' => $patient_id,
            'appointment_id' => $appointment_id
        ];
        
        $reservation = $this->tempReservationRepository->create($data);
        
        return (Object) [
            'status' => true,
            'data' => $reservation->appointment
        ];
    }

    public function updateReservation($status, $appointment_id){
        $appointment = Appointment::find($appointment_id);
        
        if($status == true && $appointment->reservation == null && $appointment->status == 'Libre') {

            //si no esta reservado y esta libre ->lo reservo
            return $this->customCreate(null, $appointment_id);
        
        } elseif($status == false && $appointment->reservation != null) {
        
            //cancelo la reserva si esta reservado
            $appointment->reservation->delete();
        
        }

        return (Object) [
            'status' => true,
            'data' => $appointment
        ];
    }

    public function detectProfessional($date, $time, $medical_study_id){
        $appointments = Appointment::where('date', $date)->where('time', $time)->get();
        //dd($appointments);
        foreach($appointments as $ap){
            $professional = $ap->professional;
            //dd($ap);
            if($professional->does($medical_study_id, $ap->date, $ap->time)){
                return $professional->id;
            }
        }
        return null;
    }
}