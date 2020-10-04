<?php

namespace App\Http\Controllers;

use App\DataTables\PatientDataTable;
use App\DataTables\PatientInsuranceDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Repositories\PatientRepository;
use App\Repositories\InsuranceRepository;
use App\Repositories\ProfessionalRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;
use Auth;
use App\Models\User;

class PatientController extends AppBaseController
{
    /** @var  PatientRepository */
    private $patientRepository;
    
    private $insuranceRepository;

    private $professionalRepository;

    public function __construct(PatientRepository $patientRepo,
                                InsuranceRepository $insuranceRepo,
                                ProfessionalRepository $professionalRepo)
    {
        $this->patientRepository = $patientRepo;

        $this->insuranceRepository = $insuranceRepo;

        $this->professionalRepository = $professionalRepo;
    }

    /**
     * Display a listing of the Patient.
     *
     * @param PatientDataTable $patientDataTable
     * @return Response
     */
    public function index(Request $request, PatientDataTable $patientDataTable)
    {   
        foreach($request->all() as $filter => $value){
            $patientDataTable = $patientDataTable->with($filter, $value);
        }
        return $patientDataTable->render('patients.index');
    }

    /**
     * Show the form for creating a new Patient.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();

        if(!$user->hasRole('secretary')){
            Flash::error('No tiene permisos para acceder a esta sección.');
            return redirect(route('patients.index'));
        }
        
        $insurances = $this->insuranceRepository->getInsurancesForSelect();

        return view('patients.create')
               ->with('insurances', $insurances);
    }

    /**
     * Store a newly created Patient in storage.
     *
     * @param CreatePatientRequest $request
     *
     * @return Response
     */
    public function store(CreatePatientRequest $request)
    {
        $user = Auth::user();

        if(!$user->hasRole('secretary')){
            Flash::error('No tiene permisos para acceder a esta sección.');
            return redirect(route('patients.index'));
        }
        $input = $request->all();

        $patient = $this->patientRepository->create($input);

        Flash::success('El paciente fue guardado correctamente');

        return redirect(route('patients.index'));
    }

    /**
     * Display the specified Patient.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id, PatientInsuranceDataTable $patientInsuranceDataTable)
    {
        $patient = $this->patientRepository->findWithoutFail($id);

        if (empty($patient)) {
            Flash::error('Paciente no encontrado');

            return redirect(route('patients.index'));
        }
        
        return $patientInsuranceDataTable
            ->with('patient_id',$patient->id)
            ->render('patients.show',[
                'patient' => $patient,
            ]);
    }

    /**
     * Show the form for editing the specified Patient.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = Auth::user();

        if(!$user->hasRole('secretary')){
            Flash::error('No tiene permisos para acceder a esta sección.');
            return redirect(route('patients.index'));
        }
        
        $patient = $this->patientRepository->findWithoutFail($id);

        if (empty($patient)) {
            Flash::error('El paciente no fue encontrado');

            return redirect(route('patients.index'));
        }

        $insurances = $this->insuranceRepository->getInsurancesForSelect();

        $professionals = $this->professionalRepository->getProfessionalsForSelect();


        return view('patients.edit')
               ->with('patient', $patient)
               ->with('insurances', $insurances)
               ->with('professionals', $professionals)
               ->with('user', $user);
    }

    /**
     * Update the specified Patient in storage.
     *
     * @param  int              $id
     * @param UpdatePatientRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatePatientRequest $request)
    {   
        $user = Auth::user();
        if(!$user->hasRole('secretary')){
            Flash::error('No tiene permisos para acceder a esta sección.');
            return redirect(route('patients.index'));
        }

        $patient = $this->patientRepository->findWithoutFail($id);

        if (empty($patient)) {
            Flash::error('El paciente no fue encontrado');

            return redirect(route('patients.index'));
        }
        
        $patient = $this->patientRepository->update($request->all(), $id);
        $patient = $this->patientRepository->updateEmail($request->get('email'), $id);
        
        Flash::success('El paciente fue actualizado correctamente');

        return redirect(route('patients.index'));
    }

    /**
     * Remove the specified Patient from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        if(!$user->hasRole('secretary')){
            Flash::error('No tiene permisos para acceder a esta sección.');
            return redirect(route('patients.index'));
        }

        $patient = $this->patientRepository->findWithoutFail($id);

        if (empty($patient)) {
            Flash::error('El paciente no fue encontrado');

            return redirect(route('patients.index'));
        }

        $this->patientRepository->delete($id);

        Flash::success('El paciente fue eliminado correctamente');

        return redirect(route('patients.index'));
    }
}
