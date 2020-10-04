<?php

namespace App\Http\Controllers;

use App\DataTables\HistoryDetailDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateHistoryDetailRequest;
use App\Http\Requests\UpdateHistoryDetailRequest;
use App\Repositories\HistoryDetailRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class HistoryDetailController extends AppBaseController
{
    /** @var  HistoryDetailRepository */
    private $historyDetailRepository;

    public function __construct(HistoryDetailRepository $historyDetailRepo)
    {
        $this->historyDetailRepository = $historyDetailRepo;
    }

    /**
     * Display a listing of the HistoryDetail.
     *
     * @param HistoryDetailDataTable $historyDetailDataTable
     * @return Response
     */
    public function index(HistoryDetailDataTable $historyDetailDataTable)
    {
        return $historyDetailDataTable->render('history_details.index');
    }

    /**
     * Show the form for creating a new HistoryDetail.
     *
     * @return Response
     */
    public function create()
    {
        return view('history_details.create');
    }

    /**
     * Store a newly created HistoryDetail in storage.
     *
     * @param CreateHistoryDetailRequest $request
     *
     * @return Response
     */
    public function store(CreateHistoryDetailRequest $request)
    {
        $input = $request->all();

        $historyDetail = $this->historyDetailRepository->create($input);

        Flash::success('Detalle de historia clínica guardado correctamente');

        return redirect(route('historyDetails.index'));
    }

    /**
     * Display the specified HistoryDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $historyDetail = $this->historyDetailRepository->findWithoutFail($id);

        if (empty($historyDetail)) {
            Flash::error('Detalle de historia clínica no encontrado');

            return redirect(route('historyDetails.index'));
        }

        return view('history_details.show')->with('historyDetail', $historyDetail);
    }

    /**
     * Show the form for editing the specified HistoryDetail.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $historyDetail = $this->historyDetailRepository->findWithoutFail($id);

        if (empty($historyDetail)) {
            Flash::error('Detalle de historia clínica no encontrado');

            return redirect(route('historyDetails.index'));
        }

        return view('history_details.edit')->with('historyDetail', $historyDetail);
    }

    /**
     * Update the specified HistoryDetail in storage.
     *
     * @param  int              $id
     * @param UpdateHistoryDetailRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHistoryDetailRequest $request)
    {
        $historyDetail = $this->historyDetailRepository->findWithoutFail($id);

        if (empty($historyDetail)) {
            Flash::error('Detalle de historia clínica no encontrado');

            return redirect(route('historyDetails.index'));
        }

        $historyDetail = $this->historyDetailRepository->update($request->all(), $id);

        Flash::success('Detalle de historia clínica actualizado correctamente');

        return redirect(route('historyDetails.index'));
    }

    /**
     * Remove the specified HistoryDetail from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $historyDetail = $this->historyDetailRepository->findWithoutFail($id);

        if (empty($historyDetail)) {
            Flash::error('Detalle de historia clínica no encontrado');

            return redirect(route('historyDetails.index'));
        }

        $this->historyDetailRepository->delete($id);

        Flash::success('Detalle de historia clínica eliminado correctamente');

        return redirect(route('historyDetails.index'));
    }
}
