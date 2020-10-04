<?php

namespace App\Http\Controllers;

use App\DataTables\AppointmentDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;

use App\Repositories\AppointmentRepository;
use App\Repositories\ProfessionalRepository;
use App\Repositories\InsuranceRepository;
use App\Repositories\MedicalStudyRepository;
use App\Repositories\PatientRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class AppointmentController extends AppBaseController
{
    /** @var  AppointmentRepository */
    private $appointmentRepository;
    
    private $patientRepository;

    private $professionalRepository;

    private $insuranceRepository;

    private $medicalStudyRepository;

    public function __construct(AppointmentRepository $appointmentRepo, ProfessionalRepository $professionalRepo, 
                                PatientRepository $patientRepo, InsuranceRepository $insuranceRepo, MedicalStudyRepository $medicalStudyRepo)
    {
        $this->appointmentRepository = $appointmentRepo;
        $this->professionalRepository = $professionalRepo;
        $this->patientRepository = $patientRepo;
        $this->insuranceRepository = $insuranceRepo; 
        $this->medicalStudyRepository = $medicalStudyRepo; 
    }

    /**
     * Display a listing of the Appointment.
     *
     * @param AppointmentDataTable $appointmentDataTable
     * @return Response
     */
    public function index(AppointmentDataTable $appointmentDataTable)
    {
        return $appointmentDataTable->render('appointments.index');
    }

    /**
     * Show the form for creating a new Appointment.
     *
     * @return Response
     */
    public function create()
    {
        $professionals = $this->professionalRepository->getProfessionalsForSelect();

        $patients = $this->patientRepository->getPatientsForSelect();

        $insurances = $this->insuranceRepository->getInsurancesForSelect();

        $medicalStudies = $this->medicalStudyRepository->getStudiesForSelect();

        return view('appointments.create')
                ->with('professionals', $professionals)
                ->with('patients', $patients)
                ->with('insurances', $insurances)
                ->with('medicalStudies', $medicalStudies);
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

        $appointment = $this->appointmentRepository->create($input);

        Flash::success('Turno médico correctamente guardado');

        return redirect(route('appointments.index'));
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
            Flash::error('Turno médico no encontrado');

            return redirect(route('appointments.index'));
        }

        return view('appointments.show')->with('appointment', $appointment);
    }

    /**
     * Show the form for editing the specified Appointment.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $appointment = $this->appointmentRepository->findWithoutFail($id);

        $professionals = $this->professionalRepository->getProfessionalsForSelect();

        $patients = $this->patientRepository->getPatientsForSelect();

        $insurances = $this->insuranceRepository->getInsurancesForSelect(1);

        $medicalStudies = $this->medicalStudyRepository->getStudiesForSelect(1);

        if (empty($appointment)) {
            Flash::error('Turno médico no encontrado');

            return redirect(route('appointments.index'));
        }

        return view('appointments.edit')
                ->with('appointment', $appointment)
                ->with('professionals', $professionals)
                ->with('patients', $patients)
                ->with('insurances', $insurances)
                ->with('medicalStudies', $medicalStudies);
    }

    /**
     * Update the specified Appointment in storage.
     *
     * @param  int              $id
     * @param UpdateAppointmentRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateAppointmentRequest $request)
    {
        $appointment = $this->appointmentRepository->findWithoutFail($id);

        if (empty($appointment)) {
            Flash::error('Turno médico no encontrado');

            return redirect(route('appointments.index'));
        }

        $appointment = $this->appointmentRepository->update($request->all(), $id);

        Flash::success('Turno médico actualizado correctamente');

        return redirect(route('appointments.index'));
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
        $appointment = $this->appointmentRepository->findWithoutFail($id);

        if (empty($appointment)) {
            Flash::error('Turno médico no encontrado');

            return redirect(route('appointments.index'));
        }

        $this->appointmentRepository->delete($id);

        Flash::success('Turno médico eliminado correctamente');

        return redirect(route('appointments.index'));
    }
}
