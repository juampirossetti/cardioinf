<?php

namespace App\Services;

use App\Models\Appointment;

use Config;

use Carbon\Carbon;

use Mail;

use App\Models\Mail as Email;

use Auth;

class EmailService
{
    public function __construct(){
        
    }

    public function sendDeleteMessage(Appointment $appointment, $save_to_db = false) {
        $email = $appointment->getEmail();
        if($email != null && $this->isValidEmail($email)){
                $data = $this->getData($appointment);

                Mail::queue('pdf.delete', $data, function ($message) use ($email, $data){
                    $message->from('cancelaciones@cardioinfantilsantafe.com', 'Centro de Cardiología Infantil');

                    $message->to($email, $data['patient_name']);

                    $message->subject('Importante: Cancelación de turno');
                });

                if($save_to_db){
                    $user = Auth::user();
                    Email::create([
                        'to' => $data['patient_name'].'<'.$email.'>',
                        'subject' => 'Email de cancelación',
                        'sended_date' => Carbon::now(),
                        'content' => '<p>Estimado Paciente,<br><br>Su turno médico del día '.$data["date"].' a las '.$data["time"].' hs con el profesional '.$data["professional_name"].' ha sido cancelado.<br> <br><div style="text-align: Right;">Muchas gracias,<br>Centro de Cardiología Infantil de Santa Fe.</div>',
                        'user_id' => $user->id
                    ]);
                }
        }
    }

    public function sendInfoMessage(Appointment $appointment) {
        $email = $appointment->getEmail();
        if($email != null && $this->isValidEmail($email)){
                $data = $this->getData($appointment);

                Mail::queue('pdf.voucher', $data, function ($message) use ($email, $data){
                    $message->from('noresponder@cardioinfantilsantafe.com', 'Centro de Cardiología Infantil');

                    $message->to($email, $data['patient_name']);

                    $message->subject('Importante: Nuevo turno médico');
                });
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
        $data['patient_name'] = $appointment->getNameForEmail();

        return $data;

    }

    public function sendEmailAndSave($data, $user_id){
        $email = $data['to'];
        if($email != null && $this->isValidEmail($email)){
                $content = $data['content'];

                Mail::queue('emails.layout', $data, function ($message) use ($email, $content, $data, $user_id){
                    $message->from('noresponder@cardioinfantilsantafe.com', 'Centro de Cardiología Infantil');

                    $message->to($email);

                    $message->subject($data['subject']);
                });

                Email::create([
                    'to' => $data['to'],
                    'subject' => $data['subject'],
                    'sended_date' => Carbon::now(),
                    'content' => $data['content'],
                    'user_id' => $user_id
                ]);


        }
    }
}