<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Repositories\PatientRepository;

use App\Models\Appointment;

use App\Http\Controllers\AppBaseController;

use App\Http\Requests\CreatePatientRequest;

use App\Http\Requests\API\ApiPatientRequest;

use Response;


class ApiPatientController extends AppBaseController {

    /** @var  AppointmentRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepository = $patientRepo;

    }

    public function show($id) {

        $patient = $this->patientRepository->findWithoutFail($id);

        if (empty($patient)) {
            
            return response()->json(['status' => 'Not Found'], 404);
        }
        return response()->json($patient->jsonResponse(), 201);
    }

    public function store(ApiPatientRequest $request) {

        if(!$request->has('dni')){
            return response()->json([
                'dni' => 'El dni no puede estar vacío'],400);            
        };

        if($request->get('dni') !== ''){
            $p = $this->patientRepository->findByDni($request->get('dni'));
            if($p !== null){
                $patient = $this->patientRepository->update($request->all(), $p->id);
            } else {
                $input = $request->all();
                $patient = $this->patientRepository->create($input);
            }
        };

        return response()->json($patient->jsonResponse(),201);
    }

    public function showByDni($dni) {

        if(is_numeric($dni) && $dni > 0 && $dni == round($dni, 0)) {
            
            $patient = $this->patientRepository->findByDni($dni);
    
            if (empty($patient)) {
                    
                return response()->json(['status' => 'Not Found'], 404);
            }
            return response()->json($patient->jsonResponse(), 201);

        } else {
            
            return response()->json(['status' => 'Bad Request'], 400);
        
        }
        
    }

    public function advancedSearch(Request $request) {

        $filter = $request->only('dni', 'name', 'surname');

        $patients = $this->patientRepository->filter($filter,10);

        return response()->json($patients, 201);
    }
};