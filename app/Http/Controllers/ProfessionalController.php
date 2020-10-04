<?php

namespace App\Http\Controllers;

use App\DataTables\ProfessionalDataTable;
use App\DataTables\ProfessionalInsuranceDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateProfessionalRequest;
use App\Http\Requests\UpdateProfessionalRequest;
use App\Repositories\ProfessionalRepository;
use App\Repositories\MedicalStudyRepository;
use App\Repositories\InsuranceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

use Auth;

use App\Models\SMConfig;
use App\Models\Professional;

class ProfessionalController extends AppBaseController
{
    /** @var  ProfessionalRepository */
    private $professionalRepository;
    private $medicalStudyRepository;
    private $insuranceRepository;

    public function __construct(ProfessionalRepository $professionalRepo, MedicalStudyRepository $studyRepo, 
                                InsuranceRepository $insuranceRepo)
    {
        $this->professionalRepository = $professionalRepo;
        $this->medicalStudyRepository = $studyRepo;
        $this->insuranceRepository = $insuranceRepo;
    }

    /**
     * Display a listing of the Professional.
     *
     * @param ProfessionalDataTable $professionalDataTable
     * @return Response
     */
    public function index(Request $request, ProfessionalDataTable $professionalDataTable)
    {   
        foreach($request->all() as $filter => $value){
            $professionalDataTable = $professionalDataTable->with($filter, $value);
        }

        return $professionalDataTable->render('professionals.index');
    }

    /**
     * Show the form for creating a new Professional.
     *
     * @return Response
     */
    public function create()
    {   
        if(SMConfig::getByKey('max_number_of_professionals') <= count(Professional::all())){

            Flash::error('Ha alcanzado la cantidad máxima de profesionales. Comuníquese con el administrador si desea modificar su plan para agregar más profesionales.');

            return redirect(route('professionals.index'));
        }
        
        $medicalStudies = $this->medicalStudyRepository->all();

        $insurances = $this->insuranceRepository->all();

        return view('professionals.create')
            ->with('medicalStudies', $medicalStudies)
            ->with('insurances', $insurances);
    }

    /**
     * Store a newly created Professional in storage.
     *
     * @param CreateProfessionalRequest $request
     *
     * @return Response
     */
    public function store(CreateProfessionalRequest $request)
    {
        if(SMConfig::getByKey('max_number_of_professionals') <= count(Professional::all())){

            Flash::error('Ha alcanzado la cantidad máxima de profesionales. Comuníquese con el administrador si desea agregar más profesionales.');

            return redirect(route('professionals.index'));
        }

        $input = $request->all();

        $professional = $this->professionalRepository->createOrUpdate($input);

        Flash::success('El médico fue guardado correctamente');

        return redirect(route('professionals.index'));
    }

    /**
     * Display the specified Professional.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $professional = $this->professionalRepository->findWithoutFail($id);

        if (empty($professional)) {
            Flash::error('Médico no encontrado');

            return redirect(route('professionals.index'));
        }
        return view('professionals.show')->with('professional', $professional);
    }

    /**
     * Show the form for editing the specified Professional.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id, ProfessionalInsuranceDataTable $professionalInsuranceDataTable)
    {
        $professional = $this->professionalRepository->findWithoutFail($id);

        $medicalStudies = $this->medicalStudyRepository->all();

        $insurances = $this->insuranceRepository->orderBy('name', 'asc')->all();

        if (empty($professional)) {
            Flash::error('Médico no encontrado');

            return redirect(route('professionals.index'));
        }

        $user = Auth::user();

        return $professionalInsuranceDataTable
            ->with('professional_id',$professional->id)
            ->render('professionals.edit',[
                'professional' => $professional,
                'medicalStudies' => $medicalStudies,
                'insurances' => $insurances,
                'user' => $user
            ]);
    }

    /**
     * Update the specified Professional in storage.
     *
     * @param  int              $id
     * @param UpdateProfessionalRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateProfessionalRequest $request)
    {
        $professional = $this->professionalRepository->findWithoutFail($id);

        if (empty($professional)) {
            Flash::error('Médico no encontrado');

            return redirect(route('professionals.index'));
        }

        $professional = $this->professionalRepository->createOrUpdate($request->all(), $id);

        Flash::success('Médico actualizado correctamente');

        //return redirect()->back();
        return redirect(route('professionals.index'));
    }

    /**
     * Remove the specified Professional from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $professional = $this->professionalRepository->findWithoutFail($id);

        if (empty($professional)) {
            Flash::error('Médico no encontrado');

            return redirect(route('professionals.index'));
        }

        $this->professionalRepository->delete($id);

        Flash::success('Médico eliminado correctamente');

        return redirect(route('professionals.index'));
    }
}
