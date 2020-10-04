<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

//use App\Services\VoucherService;

use App\Http\Controllers\AppBaseController;

use App\Models\Appointment;

use Response;


class ApiVoucherController extends AppBaseController {

    /** @var  AppointmentRepository */
    //private $voucherService;

    public function __construct(/*VoucherService $voucherServ*/)
    {
        //$this->voucherService = $voucherServ;
    }

    public function printVoucher(Appointment $appointment){

        $data['date'] = $appointment->date;
        $data['time'] = $appointment->time;
        $data['professional_name'] = isset($appointment->professional) ? $appointment->professional->getCompleteName() : '';
        $data['medical_study_name'] = isset($appointment->medicalStudy) ? $appointment->medicalStudy->name : '';
        $data['patient_name'] = isset($appointment->patient) ? $appointment->patient->getCompleteName() : '';

        //dd($data);

        $pdf = \PDF::loadView('pdf.voucher', $data);
        
        return $pdf->setPaper('a4')->download('turno.pdf');
    }
}