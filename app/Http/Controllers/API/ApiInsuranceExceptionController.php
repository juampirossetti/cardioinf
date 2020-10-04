<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Repositories\ProfessionalInsuranceRepository;

use App\Http\Controllers\AppBaseController;

class ApiInsuranceExceptionController extends AppBaseController {

    /** @var  AppointmentRepository */
    private $ProfessionalInsuranceRepository;

    public function __construct(ProfessionalInsuranceRepository $professionalInsuranceRepo)
    {
        $this->professionalInsuranceRepository = $professionalInsuranceRepo;

    }

    public function show($professional_id, $insurance_id) {

        $professionalInsurance = $this->professionalInsuranceRepository->findWithoutFailWithInsuranceID($professional_id, $insurance_id);

        if (empty($professionalInsurance)) {
            
            return response()->json(['status' => 'Not Found'], 404);
        }

        return response()->json($professionalInsurance->makeHidden([
            'id',
            'updated_at',
            'created_at',
            'enabled_appointment_text',
            'enabled_patient_text',
            'enabled_patient',
            'have_message',
            'professional_id',
            'insurance_id',
            'insurance_name'
            ]), 201);
    }
};