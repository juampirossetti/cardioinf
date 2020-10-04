<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\AppBaseController;

use Auth;

use Flash;

use App\Models\Insurance;

use App\Repositories\PatientRepository;

use App\Http\Requests\Patient\PatientProfileRequest;

class PatientProfileController extends AppBaseController
{   
    /** @var  PatientRepository */
    private $patientRepository;

    public function __construct(PatientRepository $patientRepo)
    {
        $this->patientRepository = $patientRepo;
    }

    /**
     * Display a listing of the Professional.
     *
     * @param ProfessionalDataTable $professionalDataTable
     * @return Response
     */
    public function show()
    {
        $user = Auth::user();

        $insurances = Insurance::all();

        return view('patient_section.profile.show')
            ->with('user', $user)
            ->with('insurances', $insurances);
    }

    /**
     * Update the specified Patient in storage.
     *
     * @param  int              $id
     * @param PatientProfileRequest $request
     *
     * @return Response
     */
    public function update(PatientProfileRequest $request)
    {   
        $patient = Auth::user()->patient;
    
        if (empty($patient)) {
            Flash::error('El paciente no fue encontrado');

            return redirect('/');
        }
        
        $patient = $this->patientRepository->update($request->all(), $patient->id);
        
        Flash::success('Sus datos fueron actualizados correctamente');

        return redirect(route('patient.profile'));
    }
}