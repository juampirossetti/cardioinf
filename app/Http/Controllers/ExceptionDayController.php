<?php

namespace App\Http\Controllers;

use App\DataTables\ExceptionDayDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;

// use App\Http\Requests\CreateMedicalStudyRequest;
use App\Http\Requests\ExceptionDayRequest;

use App\Repositories\MedicalStudyRepository;

use App\Repositories\ProfessionalRepository;

use App\Repositories\ExceptionDayRepository;

use Flash;
use App\Http\Controllers\AppBaseController;

use Response;

class ExceptionDayController extends AppBaseController
{
    /** @var  MedicalStudyRepository */
    private $medicalStudyRepository;
    private $professionalRepository;
    private $exceptionDayRepository;

    public function __construct(MedicalStudyRepository $medicalStudyRepo,
                                ProfessionalRepository $professionalRepo,
                                ExceptionDayRepository $exceptionDayRepo)
    {
        $this->medicalStudyRepository = $medicalStudyRepo;
        $this->professionalRepository = $professionalRepo;
        $this->exceptionDayRepository = $exceptionDayRepo;
    }

    /**
     * Display a listing of the Exception Day.
     *
     * @param MedicalStudyDataTable $medicalStudyDataTable
     * @return Response
     */
    public function index(Request $request, ExceptionDayDataTable $exceptionDayDataTable)
    {   

        return $exceptionDayDataTable->render('exceptions_days.index');
    }

    /**
     * Show the form for creating a new Exception Day.
     *
     * @return Response
     */
    public function create()
    {
        $medicalStudies = $this->medicalStudyRepository->all();

        $professionals = $this->professionalRepository->all();

        return view('exceptions_days.create')
                ->with('medicalStudies', $medicalStudies)
                ->with('professionals', $professionals);
    }

    /**
     * Store a newly created Exception Day in storage.
     *
     *
     * @return Response
     */
    public function store(ExceptionDayRequest $request)
    {
        $input = $request->all();

        $exceptionDay = $this->exceptionDayRepository->create($input);

        Flash::success('La excepción fue guardada correctamente');

        return redirect(route('exceptionsdays.index'));
    }

    /**
     * Show the form for editing the specified Exception Day.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $exceptionDay = $this->exceptionDayRepository->findWithoutFail($id);

        $medicalStudies = $this->medicalStudyRepository->all();

        $professionals = $this->professionalRepository->all();

        if (empty($exceptionDay)) {
            Flash::error('Excepción no encontrada');

            return redirect(route('exceptionsdays.index'));
        }

        return view('exceptions_days.edit')
               ->with('exceptionDay', $exceptionDay)
               ->with('professionals', $professionals)
               ->with('medicalStudies', $medicalStudies);
    }

    /**
     * Update the specified Exception Day in storage.
     *
     * @param  int              $id
     * @param ExceptionDayRequest $request
     *
     * @return Response
     */
    public function update($id, ExceptionDayRequest $request)
    {
        $exceptionDay = $this->exceptionDayRepository->findWithoutFail($id);

        if (empty($exceptionDay)) {
            Flash::error('El registro de excepción no fue encontrado');

            return redirect(route('exceptionsdays.index'));
        }

        $exceptionDay = $this->exceptionDayRepository->update($request->all(), $id);

        Flash::success('La excepción fue actualizada correctamente');

        return redirect(route('exceptionsdays.index'));
    }

    /**
     * Remove the specified Exception Day from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $exceptionDay = $this->exceptionDayRepository->findWithoutFail($id);

        if (empty($exceptionDay)) {
            Flash::error('El registro de excepción no fue encontrado');

            return redirect(route('exceptionsdays.index'));
        }

        $this->exceptionDayRepository->delete($id);

        Flash::success('La excepción fue fue eliminada correctamente');

        return redirect(route('exceptionsdays.index'));
    }
}
