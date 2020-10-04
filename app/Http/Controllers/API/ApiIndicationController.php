<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Requests\API\IndicationRequest;

use App\Repositories\IndicationRepository;

use App\Http\Controllers\AppBaseController;

class ApiIndicationController extends AppBaseController {

    /** @var  AppointmentRepository */
    private $indicationRepository;

    public function __construct(IndicationRepository $indicationRepo)
    {
        $this->indicationRepository = $indicationRepo;

    }

    public function show(IndicationRequest $request) {

        $input = $request->all();
        
        $indication = $this->indicationRepository->findWithMedicalStudyAndInsurance($input['medical_study_id'], $input['insurance_id']);

        if (empty($indication)) {
            $indication = $this->indicationRepository->findWithMedicalStudyAndInsurance($input['medical_study_id'],null);
        }

        if (empty($indication)) {
            
            return response()->json(['status' => 'Not Found'], 404);
        }

        return response()->json($indication->makeHidden([
            'id',
            'updated_at',
            'created_at',
            'enabled_appointment_text',
            'have_message',
            'medical_study_id',
            'insurance_id',
            'insurance_name'
            ]), 201);
    }
};