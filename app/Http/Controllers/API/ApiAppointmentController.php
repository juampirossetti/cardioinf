<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Repositories\AppointmentRepository;

use App\Services\AppointmentService;

use App\Services\EmailService;

use App\Models\Appointment;

use App\Http\Controllers\AppBaseController;

use App\Http\Requests\API\UpdateCalendarAppointmentRequest;

use App\Http\Requests\API\AppointmentDisponibilityRequest;

use App\Http\Requests\CreateAppointmentRequest;

use App\Repositories\PatientRepository;

use Response;

use Carbon\Carbon;

use Config;

class ApiAppointmentController extends AppBaseController {

    /** @var  AppointmentRepository */
    private $appointmentRepository;

    private $appointmentService;

    private $emailService;

    private $patientRepository;

    public function __construct(AppointmentRepository $appointmentRepo, AppointmentService $appointmentServ, EmailService $emailServ, PatientRepository $patientRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
        
        $this->appointmentService = $appointmentServ;

        $this->emailService = $emailServ;

        $this->patientRepository = $patientRepo;

    }

    public function listAppointments(Request $request){

        $max_appointments_per_day = Config::get('appointment.number_of_appointments_in_carousel');

        $data = $request->all();

        if(isset($data['professional_id']) && $data['professional_id'] != '' && $data['professional_id'] != 'null'){
            $appointments = $this->appointmentService->filterAndGroup($data, $data['professional_id'], $data['medical_study_id'], $max_appointments_per_day, false);
        } else {
            $appointments = $this->appointmentService->multipleFilterAndGroup($data, $data['medical_study_id'], $max_appointments_per_day, false);
        }
        
        return response()->json($appointments, 201);
    }

    public function update($id, UpdateCalendarAppointmentRequest $request) {
        //dd($request->all());
        $appointment = $this->appointmentRepository->findWithoutFail($id);

        if (empty($appointment)) {
            
            return response()->json(['status' => 'Not Found'], 404);
        }
        
        $data = $request->all();
        
        if(isset($data['patient_id']) && $data['patient_id'] != null){
            $patient = $this->patientRepository
                ->updatePatientFromAppointment($data, $data['patient_id']);
        }
        $appointment = $this->appointmentRepository->update($data, $id);

        return response()->json(['status' => 'The resource was updated successfully'], 201);
    }

    public function show($id) {

        $appointment = $this->appointmentRepository->findWithoutFail($id);

        if (empty($appointment)) {
            
            return response()->json(['status' => 'Not Found'], 404);
        }
        return response()->json($appointment->load('user'), 201);
    }

    /**
     * Store a newly created Appointment in storage.
     *
     * @param CreateAppointmentRequest $request
     *
     * @return Response
     */
    public function store(CreateAppointmentRequest $request)
    {
        $input = $request->all();
        
        //@CARDIOINFANTIL
        $date = Carbon::createFromFormat('Y-m-d', $input['date']);
        $professional_id = $input['professional_id'];
        if($professional_id == 1 || $professional_id == 3){ //Enzo o Carlos Pastore
            if($date->dayOfWeek == Carbon::FRIDAY){ //Viernes
                $input['professional_id'] = 5; //Turno del viernes
            } 
        }
        //@END

        $appointment = $this->appointmentRepository->create($input);

        return response()->json(['status' => 'The resource was created successfully'],200);
    }

    /**
     * Reuturns the disponibility of appointments per day.
     *
     * @return Response
     */
    public function disponibility(AppointmentDisponibilityRequest $request){
        
        $from = $request->has('from') ? $request->get('from') : Carbon::now()->format('Y-m-d');
        
        $professional_id = $request->has('professional_id') ? $request->get('professional_id') : null;
        
        $medical_study_id = $request->get('medical_study_id');

        $disponibility = $this->appointmentService->disponibility($from, $medical_study_id, $professional_id);

        return response()->json($disponibility, 201);
    }

    /**
     * Reuturns the disponibility of appointments per day extended.
     *
     * @return Response
     */
    public function disponibilityExtended(AppointmentDisponibilityRequest $request){
        

        $from = $request->has('from') ? $request->get('from') : Carbon::create(2010,01,01)->format('Y-m-d');

        $professional_id = $request->has('professional_id') ? $request->get('professional_id') : null;
        
        $medical_study_id = $request->get('medical_study_id') != '' ? $request->get('medical_study_id') : null;

        $disponibility = $this->appointmentService->disponibilityExtended($medical_study_id, $professional_id);

        return response()->json($disponibility, 201);
    }

    public function patients(Request $request) {
        
        $searchParams = null;
        if($request->has('search')){
            $searchParams = $request->get('search');
            $searchValue = $request->get('searchValue');
        }

        $patients = [];
        if($searchParams != null){
            $patients = $this->patientRepository->select2Search($searchParams, $searchValue);
        }
        
        return response()->json([
            'patients' => $patients
        ], 201);        
    }

    public function search(Request $request){
        $appointments = null;
        if($request->has('dni') && $request->get('dni') !== ''){
            //dd($request->get('dni'));
            $appointments = $this->appointmentRepository->findByDni($request->get('dni'));
        } else {
            if( ($request->has('name') && $request->get('name') !== '') ||
                ($request->has('surname') && $request->get('surname') !== '') ){
                    $name = $request->has('name') ? $request->get('name') : null;
                    $surname = $request->has('surname') ? $request->get('surname') : null;
                    $appointments = $this->appointmentRepository->findByNameAndSurname($name, $surname);
                }
        }
        if ($appointments == null){
            return response()->json([
                'error' => 'Los campos de búsqueda no pueden estar todos vacíos.'
            ], 400);
        } else {
            return response()->json([
                'appointments' => $appointments->load('user')
            ], 201);
        }
    }

    public function destroy(Request $request, $id) {
        
        $send_email = $request->has('send_email') ? $request->get('send_email') : null;

        $appointment = $this->appointmentRepository->findWithoutFail($id);
        
        if(empty($appointment)) {
            
            return response()->json(['status' => 'Not Found'], 404);
        }
        
        if($send_email == "true"){
            $this->emailService->sendDeleteMessage($appointment);
        }

        $appointment = $this->appointmentRepository->delete($id);
        

        return response()->json(['status' => 'The resource was deleted successfully'], 200);
    }
};