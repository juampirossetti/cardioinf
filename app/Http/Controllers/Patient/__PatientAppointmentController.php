<?php 

namespace App\Http\Controllers\Patient;

use App\DataTables\Patient\PatientAppointmentDataTable;
use App\Http\Requests\Patient\UpdatePatientAppointmentRequest;
use App\Http\Requests;

use App\Repositories\AppointmentRepository;

use App\Repositories\ProfessionalRepository;

use App\Repositories\PatientRepository;

use App\Repositories\InsuranceRepository;

use App\Repositories\MedicalStudyRepository;

use App\Repositories\AuditoriaRepository;

use Flash;

use Config;

use App\Http\Controllers\AppBaseController;

use Response;

use App\Models\Appointment;

use App\Models\Professional;

use App\Models\MedicalStudy;

use Illuminate\Http\Request;

use App\Helpers\TimetableFormatter;

use Auth;

use App\Services\Patient\PatientAppointmentService;

use App\Services\MedicalStudyService;

use Redirect;

use Carbon\Carbon;

class PatientAppointmentController extends AppBaseController
{
    /** @var  AppointmentRepository */
    private $appointmentRepository;
    
    private $patientRepository;

    private $professionalRepository;

    private $insuranceRepository;

    private $medicalStudyRepository;

    private $auditoriaRepository;

    private $patientAppointmentService;
    
    private $medicalStudyService;


    public function __construct(AppointmentRepository $appointmentRepo, ProfessionalRepository $professionalRepo, AuditoriaRepository $auditoriaRepo,
                                PatientRepository $patientRepo, InsuranceRepository $insuranceRepo, 
                                MedicalStudyRepository $medicalStudyRepo, patientAppointmentService $patientAppointmentServ,
                                MedicalStudyService $medicalStudyServ)
    {
        $this->appointmentRepository = $appointmentRepo;
        $this->professionalRepository = $professionalRepo;
        $this->patientRepository = $patientRepo;
        $this->insuranceRepository = $insuranceRepo;
        $this->medicalStudyRepository = $medicalStudyRepo;
        $this->patientAppointmentService = $patientAppointmentServ;
        $this->medicalStudyService = $medicalStudyServ;
        $this->auditoriaRepository = $auditoriaRepo;

    }

    /**
     * Display a listing of the Appointment.
     *
     * @param AppointmentDataTable $appointmentDataTable
     * @return Response
     */
    public function index(PatientAppointmentDataTable $appointmentDataTable)
    {
        $professionals = $this->professionalRepository->getProfessionalsForSelect('patient');

        $medicalStudies = MedicalStudy::where('patient_enabled',1);
        
        return $appointmentDataTable
            ->with('patient_id', Auth::user()->patient->id)
            ->with('user_id', Auth::user()->id)
            ->render('patient_section.appointments.index',['professionals' => $professionals, 'medicalStudies' => $medicalStudies]);
    }

    /**
     * Show the form for creating a new Appointment.
     *
     * @return Response
     */
    public function create(Request $request)
    {
        //redirecciono si vienen en la url medical study y professional al mismo tiempo
        if($request->has('medical_study_id') && $request->has('professional_id') ){
            $medical_study_id = $request->has('medical_study_id') ? $request->input('medical_study_id') : null;
            if($medical_study_id != null && $medical_study_id != '' && $medical_study_id != 'null'){
                return Redirect::route('patient.appointments.create',['medical_study_id' => $medical_study_id]);
            }
            
            $professional_id = $request->has('professional_id') ? $request->input('professional_id') : null;
            if($professional_id != null && $professional_id != '' && $professional_id != 'null'){
                return Redirect::route('patient.appointments.create',['professional_id' => $professional_id]);
            }

        }

        if( $request->has('professional_id') ){ //con profesional asignado
        
            $professional_id = $request->input('professional_id');
            $professional = $this->professionalRepository->findWithoutFail($professional_id);
            $insurances = $this->insuranceRepository->getInsurancesForProfessional($professional_id, true);
            $insurances = $insurances->pluck('insurance.name', 'insurance.id')->toArray();
            
            if (empty($professional) && $professional_id != null) {
                return redirect(route('patient.appointments.index'));
            }
            
            $medicalStudies = $professional->medicalStudies;
            $medical_study_id = null;
        
        } elseif($request->has('medical_study_id')) { //sin profesional asignado (con estudio medico asignado)

            $professional = new Professional();
            $professional->id = null;
            $professional->name = 'Dependerá del estudio que desea realizarse. Aclaración: Los Ecocardiograma Doppler Color Pediátrico los días viernes, los realiza el Dr. Carlos Pastore o Dr. Enzo Pastore.';

            //$insurances = $this->insuranceRepository->pluck('name', 'id')->toArray();
            
            $medical_study_id = $request->input('medical_study_id');
            
            $insurances = $this->medicalStudyService->getInsurancesAvailablesArray($medical_study_id);
            
            $medicalStudies = $this->medicalStudyRepository->all();

        }else{ //error porque no tiene ni profesional ni estudio medico
            return Redirect::route('patient.appointments.index');
        }

        
        $user = Auth::user();

        

        return view('patient_section.appointments.create')
            ->with('professional', $professional)
            ->with('medical_study_id', $medical_study_id)
            ->with('medicalStudies', $medicalStudies)
            ->with('insurances', $insurances)
            ->with('user', $user);
    }

    /**
     * Update the specified Appointment in storage.
     *
     * @param  int              $id
     * @param UpdateAppointmentRequest $request
     *
     * @return Response
     */
    public function update(UpdatePatientAppointmentRequest $request)
    {   
        //dd($request->all());

        $input = $request->only('medical_study_id', 'insurance_id','owner');

        if($input['owner'] != 'me'){
            if($request->has('patient_name')){
                $input['patient_name'] = $request->get('patient_name');
            }
            if($request->has('patient_surname')){
                $input['patient_surname'] = $request->get('patient_surname');
            }
            if($request->has('patient_dni')){
                $input['patient_dni'] = $request->get('patient_dni');
            }
        }
        
        $input['patient_id'] = Auth::user()->patient->id;
        $input['user_id'] = Auth::user()->id;
        
        $input['status'] = Config::get('appointment.status.ocupado');

        $status = $this->patientAppointmentService->saveAppointmentAfterReservation($input, $request->get('appointment_id'));

        if ($status == 'max_appointments_per_professional'){
            Flash::error('Usted tiene pendiente la máxima cantidad de turnos para este profesional. Cancele otros turnos antes de intentar nuevamente.');
            return redirect(route('patient.appointments.index'));
        }

        if ($status == 'error'){
            Flash::error('Hubo un error con la reserva de su turno. Por favor intente nuevamente. Recuerde que el nombre, apellido y DNI son obligatorios.');
            return redirect(route('patient.appointments.create', ['professional_id' => $request->get('professional_id')]));
        }


        //auditoria
        $app_id = $request->get('appointment_id');
        $appoint = $this->appointmentRepository->findWithoutFail($app_id);
        $this->auditoriaRepository->create([
            'date' => Carbon::now(-3),
            'category' => 'Nuevo Turno',
            'content' => 'El usuario '. Auth::user()->email .' ha solicitado un turno para el doctor '. $appoint->professional->completeName.' para el día '.$appoint->date.' a las '.$appoint->time,
        ]);
        //end-auditoria

        Flash::success('Su turno médico fue agendado correctamente.');
        return redirect(route('patient.appointments.index'));
    }

    /**
     * Display the specified Appointment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $appointment = $this->appointmentRepository->findWithoutFail($id);

        if (empty($appointment)) {
            Flash::error('Appointment not found');

            return redirect(route('appointments.index'));
        }

        return view('patient_section.appointments.show')->with('appointment', $appointment);
    }

    /**
     * Remove the specified Appointment from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //dd('aca');

        $appointment = $this->appointmentRepository->findWithoutFail($id);

        if (empty($appointment)) {
            Flash::error('Turno no encontrado');

            return redirect(route('patient_layout.appointments.index'));
        }

        //auditoria
        $this->appointmentRepository->setFree($id);
        
        $this->auditoriaRepository->create([
            'date' => Carbon::now(-3),
            'category' => 'Turno Cancelado',
            'content' => 'El usuario '. Auth::user()->email .' ha cancelado el turno para el doctor '. $appointment->professional->completeName.' para el día '.$appointment->date.' a las '.$appointment->time,
        ]);
        //end-auditoria

        Flash::success('El turno fue cancelado correctamente.');

        return redirect(route('patient.appointments.index'));
    }
}
