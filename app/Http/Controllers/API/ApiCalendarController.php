<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Repositories\AppointmentRepository;

use App\Repositories\ProfessionalRepository;

use App\Services\AppointmentService;

use App\Models\Appointment;

use App\Http\Controllers\AppBaseController;

use App\Http\Requests\CreateCalendarRequest;

use App\Http\Requests\API\BulkActionRequest;

use Response;

use Auth;

class ApiCalendarController extends AppBaseController {

    /** @var  AppointmentRepository */
    private $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepo, ProfessionalRepository $professionalRepo,
                                AppointmentService $appointmentServ)
    {
        $this->appointmentRepository = $appointmentRepo;

        $this->professionalRepository = $professionalRepo;

        $this->appointmentService = $appointmentServ;

    }

    public function listAppointments(Request $request){

        $user = Auth::user();

        if($user->hasRole('professional')){
             if(empty($user->professional) ||
                !$request->has('professional_id') ||
                $request->get('professional_id') != $user->professional->id){
                    return response()->json(['status' => 'Unauthorized access'], 400);
             }
        }

        $appointment = $this->appointmentRepository->filter($request->all());

        return response()->json(
            $appointment->load('user')->makeHidden(Appointment::$hiddenJson, 201)->toArray());
    }

    public function bulkStore(CreateCalendarRequest $request) 
    {
        $professional = $this->professionalRepository->findWithoutFail($request->get('professional_id'));
        
        $appointments = $this->appointmentService->createBulk($request->all());
        
        if (empty($appointments)) {
            //Flash::error('Ningún turno ha sido dado de alta. Verifique que el profesional trabaje esos días y que los turnos no hayan sido dados de alta anteriormente.');

            return response()->json(['status' => 'No new appointments'], 400);
        }
        
        //Flash::success('Se dieron de alta '.$appointments.' nuevos turnos.');

        return response()->json(['status' => $appointments.' nuevos turnos han sido dado de alta.'],201);
        
    }

    public function bulkAction(BulkActionRequest $request)
    {
        $professional = $this->professionalRepository->findWithoutFail($request->get('professional_id'));

        $input = $request->all();
        
        $send_email = false;
        
        if(isset($input['send_email']) && $input['send_email'] == 1){
            $send_email = true;
        }

        $appointments = $this->appointmentService->bulkAction($input['action'], $input, $send_email);

        return response()->json(['status' => 'turnos modificados correctamente'],201);
    }
}