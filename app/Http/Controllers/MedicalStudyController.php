<?php

namespace App\Http\Controllers;

use App\DataTables\MedicalStudyDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateMedicalStudyRequest;
use App\Http\Requests\UpdateMedicalStudyRequest;
use App\Repositories\MedicalStudyRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class MedicalStudyController extends AppBaseController
{
    /** @var  MedicalStudyRepository */
    private $medicalStudyRepository;

    public function __construct(MedicalStudyRepository $medicalStudyRepo)
    {
        $this->medicalStudyRepository = $medicalStudyRepo;
    }

    /**
     * Display a listing of the MedicalStudy.
     *
     * @param MedicalStudyDataTable $medicalStudyDataTable
     * @return Response
     */
    public function index(Request $request, MedicalStudyDataTable $medicalStudyDataTable)
    {   
        foreach($request->all() as $filter => $value){
            $medicalStudyDataTable = $medicalStudyDataTable->with($filter, $value);
        }
        return $medicalStudyDataTable->render('medical_studies.index');
    }

    /**
     * Show the form for creating a new MedicalStudy.
     *
     * @return Response
     */
    public function create()
    {
        return view('medical_studies.create');
    }

    /**
     * Store a newly created MedicalStudy in storage.
     *
     * @param CreateMedicalStudyRequest $request
     *
     * @return Response
     */
    public function store(CreateMedicalStudyRequest $request)
    {
        $input = $request->all();

        $medicalStudy = $this->medicalStudyRepository->create($input);

        Flash::success('El estudio médico fue guardado correctamente');

        return redirect(route('medicalStudies.index'));
    }

    /**
     * Display the specified MedicalStudy.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $medicalStudy = $this->medicalStudyRepository->findWithoutFail($id);

        if (empty($medicalStudy)) {
            Flash::error('El estudio médico no fue encontrado');

            return redirect(route('medicalStudies.index'));
        }

        return view('medical_studies.show')->with('medicalStudy', $medicalStudy);
    }

    /**
     * Show the form for editing the specified MedicalStudy.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $medicalStudy = $this->medicalStudyRepository->findWithoutFail($id);

        if (empty($medicalStudy)) {
            Flash::error('El estudio médico no fue encontrado');

            return redirect(route('medicalStudies.index'));
        }

        return view('medical_studies.edit')->with('medicalStudy', $medicalStudy);
    }

    /**
     * Update the specified MedicalStudy in storage.
     *
     * @param  int              $id
     * @param UpdateMedicalStudyRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateMedicalStudyRequest $request)
    {
        $medicalStudy = $this->medicalStudyRepository->findWithoutFail($id);

        if (empty($medicalStudy)) {
            Flash::error('El estudio médico no fue encontrado');

            return redirect(route('medicalStudies.index'));
        }

        $medicalStudy = $this->medicalStudyRepository->update($request->all(), $id);

        Flash::success('El estudio médico fue actualizado correctamente');

        return redirect(route('medicalStudies.index'));
    }

    /**
     * Remove the specified MedicalStudy from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $medicalStudy = $this->medicalStudyRepository->findWithoutFail($id);

        if (empty($medicalStudy)) {
            Flash::error('El estudio médico no fue encontrado');

            return redirect(route('medicalStudies.index'));
        }

        $this->medicalStudyRepository->delete($id);

        Flash::success('El estudio médico fue eliminado correctamente');

        return redirect(route('medicalStudies.index'));
    }
}
