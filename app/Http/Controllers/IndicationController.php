<?php

namespace App\Http\Controllers;

use App\DataTables\IndicationDataTable;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\Http\Requests\IndicationRequest;

use App\Repositories\InsuranceRepository;

use App\Repositories\IndicationRepository;

use App\Repositories\MedicalStudyRepository;

use Flash;

use App\Http\Controllers\AppBaseController;

use Response;

use App\Models\Indication;

class IndicationController extends AppBaseController
{
    private $insuranceRepository;
 
    private $medicalStudyRepository;

    private $indicationRepository;

    public function __construct(InsuranceRepository $insuranceRepo,
                                MedicalStudyRepository $medicalStudyRepo,
                                IndicationRepository $indicationRepo)
    {
        $this->insuranceRepository = $insuranceRepo;
        
        $this->medicalStudyRepository = $medicalStudyRepo;

        $this->indicationRepository = $indicationRepo;        
    }

    /**
     * Display a listing of the Insurance.
     *
     * @param InsuranceDataTable $insuranceDataTable
     * @return Response
     */
    public function index(Request $request, IndicationDataTable $indicationDataTable)
    {   
        foreach($request->all() as $filter => $value){
            $indicationDataTable = $indicationDataTable->with($filter, $value);
        }
        
        return $indicationDataTable->render('indications.index', ['data' => $request->all()]);
    }

    /**
     * Show the form for creating a new Insurance.
     *
     * @return Response
     */
    public function create()
    {
        $insurances = $this->insuranceRepository->getInsurancesForSelect();

        $medicalStudies = $this->medicalStudyRepository->getStudiesForSelect();
        
        return view('indications.create')
               ->with('insurances', $insurances)
               ->with('medicalStudies', $medicalStudies);
    }

    /**
     * Store a newly created Indication in storage.
     *
     * @param IndicationRequest $request
     *
     * @return Response
     */
    public function store(IndicationRequest $request)
    {
        $input = $request->all();

        if($input['insurance_id'] == ''){ //Validacion de estudio médico con Todas las obras sociales
            $other = Indication::where('insurance_id',null)->where('medical_study_id',$input['medical_study_id'])->first();
            if(!empty($other)){
                Flash::error('Ya existen indicaciones para el Estudio Médico seleccionado y Todas las obras sociales.');

                return redirect(route('indications.create'))->withInput();    
            }
        }

        $indication = $this->indicationRepository->create($input);

        Flash::success('Las indicaciones fueron guardadas correctamente');

        return redirect(route('indications.index'));
    }

    /**
     * Show the form for editing the specified Indication.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $indication = $this->indicationRepository->findWithoutFail($id);

        if (empty($indication)) {
            Flash::error('Las indicaciones no fueron encontradas');

            return redirect(route('indications.index'));
        }

        $insurances = $this->insuranceRepository->getInsurancesForSelect();

        $medicalStudies = $this->medicalStudyRepository->getStudiesForSelect();

        return view('indications.edit')
                ->with('indication', $indication)
                ->with('insurances', $insurances)
                ->with('medicalStudies', $medicalStudies);
    }

    /**
     * Update the specified Indication in storage.
     *
     * @param  int              $id
     * @param IndicationRequest $request
     *
     * @return Response
     */
    public function update($id, IndicationRequest $request)
    {   
        $input = $request->all();

        if($input['insurance_id'] == ''){ //Validacion de estudio médico con Todas las obras sociales
            $other = Indication::where('insurance_id',null)->where('medical_study_id',$input['medical_study_id'])->first();
            if(!empty($other) && $other->id != $id){
                Flash::error('Ya existen indicaciones para el Estudio Médico seleccionado y Todas las obras sociales.');

                return redirect(route('indications.edit', $id))->withInput();    
            }
        }

        $indication = $this->indicationRepository->findWithoutFail($id);

        if (empty($indication)) {
            Flash::error('Las indicaciones no fueron encontradas.');

            return redirect(route('indications.index'));
        }

        $indication = $this->indicationRepository->update($request->all(), $id);

        Flash::success('Las indicaciones fueron actualizadas correctamente');

        return redirect(route('indications.index'));
    }

    /**
     * Remove the specified Indication from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $indication = $this->indicationRepository->findWithoutFail($id);

        if (empty($indication)) {
            Flash::error('Las indicaciones no fueron encontradas.');

            return redirect(route('indications.index'));
        }

        $this->indicationRepository->delete($id);

        Flash::success('Las indicaciones fueron eliminadas correctamente.');

        return redirect(route('indications.index'));
    }
}