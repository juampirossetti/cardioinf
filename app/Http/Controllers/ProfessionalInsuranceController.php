<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Professional;

use App\Models\ProfessionalInsurance;

use App\Repositories\ProfessionalInsuranceRepository;

use App\Http\Requests\UpdateProfessionalInsuranceRequest;
use Flash;

class ProfessionalInsuranceController extends Controller
{
    private $professionalInsuranceRepository;

    public function __construct(ProfessionalInsuranceRepository $professionalInsuranceRepo)
    {
        $this->professionalInsuranceRepository = $professionalInsuranceRepo; 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Professional $professional, ProfessionalInsurance $insurance)
    {
        if(!$professional->insurances->pluck('id')->contains($insurance->insurance->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('professionals.index'));
        }

        return view('professionals.insurances.edit')->with('insuranceException', $insurance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Professional $professional, ProfessionalInsurance $insurance, UpdateProfessionalInsuranceRequest $request)
    {
        if(!$professional->insurances->pluck('id')->contains($insurance->insurance->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('professionals.index'));
        }

        $insurance = $this->professionalInsuranceRepository->update($request->all(), $insurance->id);

        Flash::success('La excepción fue actualizada correctamente.');

        return redirect(route('professionals.edit', $professional->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professional $professional, ProfessionalInsurance $insurance)
    {
        if(!$professional->insurances->pluck('id')->contains($insurance->insurance->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('professionals.index'));
        }

        $insurance->delete();

        Flash::success('Asociación de obra social y profesional eliminada correctamente');

        return redirect()->back();
    }
}
