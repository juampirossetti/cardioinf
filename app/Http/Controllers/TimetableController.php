<?php

namespace App\Http\Controllers;

use App\DataTables\TimetableDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTimetableRequest;
use App\Http\Requests\UpdateTimetableRequest;

use App\Repositories\TimetableRepository;
use App\Repositories\ProfessionalRepository;
use App\Repositories\MedicalStudyRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TimetableController extends AppBaseController
{
    /** @var  TimetableRepository */
    private $timetableRepository;
    private $professionalRepository;
    private $medicalStudyRepository;

    public function __construct(TimetableRepository $timetableRepo, ProfessionalRepository $professionalRepo, 
                                MedicalStudyRepository $medicalStudyRepo)
    {
        $this->timetableRepository = $timetableRepo;
        $this->professionalRepository = $professionalRepo;
        $this->medicalStudyRepository = $medicalStudyRepo;
    }

    /**
     * Display a listing of the Timetable.
     *
     * @param TimetableDataTable $timetableDataTable
     * @return Response
     */
    public function index(TimetableDataTable $timetableDataTable)
    {
        return $timetableDataTable->render('timetables.index');
    }

    /**
     * Show the form for creating a new Timetable.
     *
     * @return Response
     */
    public function create()
    {
        $professionals = $this->professionalRepository->getProfessionalsForSelect();

        $medicalStudies = $this->medicalStudyRepository->getStudiesForSelect();
        
        return view('timetables.create')
               ->with('professionals', $professionals)
               ->with('medicalStudies', $medicalStudies);
    }

    /**
     * Store a newly created Timetable in storage.
     *
     * @param CreateTimetableRequest $request
     *
     * @return Response
     */
    public function store(CreateTimetableRequest $request)
    {
        $input = $request->all();

        $timetable = $this->timetableRepository->create($input);

        Flash::success('El horario de atención fue guardado correctamente');

        return redirect(route('timetables.index'));
    }

    /**
     * Display the specified Timetable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $timetable = $this->timetableRepository->findWithoutFail($id);

        $studies_timetable = $timetable->medicalStudies;

        if (empty($timetable)) {
            Flash::error('El horario de atención no fue encontrado');

            return redirect(route('timetables.index'));
        }

        return view('timetables.show')
                ->with('timetable', $timetable)
                ->with('studies_timetable', $studies_timetable);
    }

    /**
     * Show the form for editing the specified Timetable.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $timetable = $this->timetableRepository->findWithoutFail($id);

        $professionals = $this->professionalRepository->getProfessionalsForSelect();

        $medicalStudies = $this->medicalStudyRepository->getStudiesForSelect();
        
        if (empty($timetable)) {
            Flash::error('El horario de atención no fue encontrado');

            return redirect(route('timetables.index'));
        }

        return view('timetables.edit')
               ->with('timetable', $timetable)
               ->with('professionals', $professionals)
               ->with('medicalStudies', $medicalStudies);
    }

    /**
     * Update the specified Timetable in storage.
     *
     * @param  int              $id
     * @param UpdateTimetableRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTimetableRequest $request)
    {
        $timetable = $this->timetableRepository->findWithoutFail($id);

       // dd($request->all());
        if (empty($timetable)) {
            Flash::error('El horario de atención no fue encontrado');

            return redirect(route('timetables.index'));
        }

        $timetable = $this->timetableRepository->update($request->all(), $id);

        Flash::success('El horario de atención fue actualizado correctamente');

        return redirect(route('timetables.index'));
    }

    /**
     * Remove the specified Timetable from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $timetable = $this->timetableRepository->findWithoutFail($id);

        if (empty($timetable)) {
            Flash::error('El horario de atención no fue encontrado');

            return redirect(route('timetables.index'));
        }

        $this->timetableRepository->delete($id);

        Flash::success('El horario de atención fue eliminado correctamente');

        return redirect(route('timetables.index'));
    }
}
