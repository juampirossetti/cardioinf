<?php

namespace App\Http\Controllers;

use App\DataTables\HistoryDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateHistoryRequest;
use App\Http\Requests\UpdateHistoryRequest;
use App\Repositories\HistoryRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class HistoryController extends AppBaseController
{
    /** @var  HistoryRepository */
    private $historyRepository;

    public function __construct(HistoryRepository $historyRepo)
    {
        $this->historyRepository = $historyRepo;
    }

    /**
     * Display a listing of the History.
     *
     * @param HistoryDataTable $historyDataTable
     * @return Response
     */
    public function index(HistoryDataTable $historyDataTable)
    {
        return $historyDataTable->render('histories.index');
    }

    /**
     * Show the form for creating a new History.
     *
     * @return Response
     */
    public function create()
    {
        return view('histories.create');
    }

    /**
     * Store a newly created History in storage.
     *
     * @param CreateHistoryRequest $request
     *
     * @return Response
     */
    public function store(CreateHistoryRequest $request)
    {
        $input = $request->all();

        $history = $this->historyRepository->create($input);

        Flash::success('Historia clínica guardada correctamente');

        return redirect(route('histories.index'));
    }

    /**
     * Display the specified History.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $history = $this->historyRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('histories.index'));
        }

        return view('histories.show')->with('history', $history);
    }

    /**
     * Show the form for editing the specified History.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $history = $this->historyRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('histories.index'));
        }

        return view('histories.edit')->with('history', $history);
    }

    /**
     * Update the specified History in storage.
     *
     * @param  int              $id
     * @param UpdateHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateHistoryRequest $request)
    {
        $history = $this->historyRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('histories.index'));
        }

        $history = $this->historyRepository->update($request->all(), $id);

        Flash::success('Historia clínica actualizada correctamente');

        return redirect(route('histories.index'));
    }

    /**
     * Remove the specified History from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $history = $this->historyRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('histories.index'));
        }

        $this->historyRepository->delete($id);

        Flash::success('Historia clínica eliminada correctamente');

        return redirect(route('histories.index'));
    }
}
