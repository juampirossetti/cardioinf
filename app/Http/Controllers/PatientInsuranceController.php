<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;

use App\Models\PatientInsurance;

use App\Repositories\PatientInsuranceRepository;

use App\Http\Requests\PatientInsuranceRequest;

use Flash;

use App\Models\Insurance;

class PatientInsuranceController extends Controller
{
    private $patientInsuranceRepository;

    public function __construct(PatientInsuranceRepository $patientInsuranceRepo)
    {
        $this->patientInsuranceRepository = $patientInsuranceRepo; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient, PatientInsurance $insurance)
    {
        if(!$patient->insurances->pluck('id')->contains($insurance->insurance->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('patients.index'));
        }

        $insurances = Insurance::all();

        return view('patients.insurances.edit')
            ->with('patientInsurance', $insurance)
            ->with('insurances', $insurances);
    }

    /**
     * Show the form for creating a new History.
     *
     * @return Response
     */
    public function create(Patient $patient)
    {
        $insurances = Insurance::all();
        return view('patients.insurances.create')
            ->with('patient',$patient)
            ->with('insurances', $insurances);
    }

    /**
     * Store a newly created History in storage.
     *
     * @param CreateHistoryRequest $request
     *
     * @return Response
     */
    public function store(Patient $patient, PatientInsuranceRequest $request)
    {
        $input = $request->all();

        $patient_insurance = $this->patientInsuranceRepository->create($input);

        Flash::success('Obra social guardada correctamente');

        return redirect(route('patients.show', $patient->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Patient $patient, PatientInsurance $insurance, PatientInsuranceRequest $request)
    {
        if(!$patient->insurances->pluck('id')->contains($insurance->insurance->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('patients.index'));
        }

        $insurance = $this->patientInsuranceRepository->update($request->all(), $insurance->id);

        Flash::success('La obra social fue actualizada correctamente.');

        return redirect(route('patients.show', $patient->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient, PatientInsurance $insurance)
    {
        if(!$patient->insurances->pluck('id')->contains($insurance->insurance->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('patients.index'));
        }

        $insurance->delete();

        Flash::success('Asociación de obra social y paciente eliminada correctamente');

        return redirect()->back();
    }
}
