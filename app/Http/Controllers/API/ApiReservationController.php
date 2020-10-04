<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Requests\API\CreateTempReservationRequest;
use App\Http\Requests\API\CreateAppointmentReservationRequest;

use App\Services\TempReservationService;

use App\Http\Controllers\AppBaseController;

use Auth;

use Response;


class ApiReservationController extends AppBaseController {
    
    private $tempReservationService;

    public function __construct(TempReservationService $tempReservationServ)
    {
        $this->tempReservationService = $tempReservationServ;
    }

    public function reserve(CreateTempReservationRequest $request) {
        $data = $request->all();
        
        if($data['professional_id'] == ''){ //no tiene profesional asignado el turno todavia
            $data['professional_id'] = $this->tempReservationService->detectProfessional($data['date'], $data['time'], $data['medical_study_id']);
        }

        $user = Auth::guard('api')->user();
        
        if ($request->get('date') == "" && $request->time == ""){
            $result = $this->tempReservationService->createEmpty($user->patient->id);
        }else{
            $result = $this->tempReservationService->validateAndCreate($data, $user->patient->id);
        }
        
        if($result->status == true){
            return response()->json(['data' => $result->data], 201);
        }else {
            return response()->json(['message' => 'Could not reserve appointment'], 404);
            
        }
        
    }

    public function reservation(CreateAppointmentReservationRequest $request) {
        $data = $request->all();

        $result = $this->tempReservationService->updateReservation($data['reserve'], $data['id']);

        if($result->status == true){
            return response()->json(['data' => $result->data], 201);
        }else {
            return response()->json(['message' => 'Could not reserve appointment'], 404);
            
        }
    }


};