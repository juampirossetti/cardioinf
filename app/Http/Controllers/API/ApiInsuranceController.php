<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Services\MedicalStudyService;

use App\Repositories\InsuranceRepository;

use App\Http\Requests\API\MedicalInsuranceRequest;

use App\Http\Controllers\AppBaseController;

class ApiInsuranceController extends AppBaseController {

    /** @var  MedicalStudyService */
    private $medicalStudyService;

    public function __construct(MedicalStudyService $medicalStudyServ, InsuranceRepository $insuranceRepo)
    {
        $this->medicalStudyService = $medicalStudyServ;
        $this->insuranceRepository = $insuranceRepo;

    }

    public function getAvailablesFromMedicalStudy(MedicalInsuranceRequest $request) {

        $medical_study_id = $request->get('medical_study_id');
        
        $enabled = $patient_enabled = true;

        if($request->has('enabled')){
            $enabled = $request->get('enabled') === "true" ? true : false; 
        }
        
        if($request->has('patient_enabled')){
            $patient_enabled = $request->get('patient_enabled') === "true" ? true : false;
        }

        $insurances = $this->medicalStudyService->getInsurancesAvailables($medical_study_id, $enabled, $patient_enabled);
        
        return response()->json($insurances, 201);
    }

    public function availables(Request $request){
        $searchParams = null;
        if($request->has('search')){
            $searchParams = $request->get('search');
        }

        $insurances = [];
        if($searchParams != null){
            $insurances = $this->insuranceRepository->select2Search($searchParams);
        }

        return response()->json([
            'insurances' => $insurances
        ], 201);  
    }
};