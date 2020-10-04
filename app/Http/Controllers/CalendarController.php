<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Requests\CreateCalendarRequest;

use App\Repositories\ProfessionalRepository;
use App\Repositories\PatientRepository;
use App\Repositories\InsuranceRepository;
use App\Repositories\MedicalStudyRepository;

use App\Services\AppointmentService;

use Flash;

use Auth;

use App\Http\Controllers\AppBaseController;

class CalendarController extends AppBaseController
{
    /**
     * Display the calendar of appointments.
     */
    private $professionalRepository;

    private $patientRepository;

    private $insuranceRepository;

    private $medicalStudyRepository;

    private $appointmentService;

    public function __construct(ProfessionalRepository $professionalRepo, AppointmentService $appointmentServ,
                                PatientRepository $patientRepo, InsuranceRepository $insuranceRepo, MedicalStudyRepository $medicalStudyRepo)
    {
        $this->professionalRepository = $professionalRepo; 
        $this->patientRepository = $patientRepo; 
        $this->insuranceRepository = $insuranceRepo; 
        $this->medicalStudyRepository = $medicalStudyRepo; 
        $this->appointmentService = $appointmentServ;

    }
    public function index()
    {
        $professionals = $this->professionalRepository->getProfessionalsForSelect('secretary');

        $patients = $this->patientRepository->getPatientsForSelect();

        $insurances = $this->insuranceRepository->getInsurancesForSelect();

        $medicalStudies = $this->medicalStudyRepository->getStudiesForSelect();

        $user = Auth::user();

        return view('calendar.index')
               ->with('professionals', $professionals)
               ->with('patients', $patients)
               ->with('insurances', $insurances)
               ->with('medicalStudies', $medicalStudies)
               ->with('user', $user);
    }

    public function store(CreateCalendarRequest $request) 
    {
        $professional = $this->professionalRepository->findWithoutFail($request->get('professional_id'));

        dd($professional);
        
        $appointments = $this->appointmentService->createBulk($request->all());
        
        if (empty($appointments)) {
            Flash::error('Ningún turno ha sido dado de alta. Verifique que el profesional trabaje esos días y que los turnos no hayan sido dados de alta anteriormente.');

            return redirect(route('calendar.index'));
        }
        
        Flash::success('Se dieron de alta '.$appointments.' nuevos turnos.');

        return redirect(route('calendar.index'));
        
    }
}
