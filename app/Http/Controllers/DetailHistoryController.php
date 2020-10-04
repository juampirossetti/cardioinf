<?php

namespace App\Http\Controllers;

use App\DataTables\HistoryDetailDataTable;

use App\Http\Requests;

use App\Http\Requests\HistoryDetailRequest;

use App\Repositories\HistoryDetailRepository;

use Flash;

use App\Http\Controllers\AppBaseController;

use Response;

use Carbon\Carbon;

class DetailHistoryController extends AppBaseController
{
    /** @var  HistoryDetailRepository */
    private $historyDetailRepository;

    public function __construct(HistoryDetailRepository $historyDetailRepo)
    {
        $this->historyDetailRepository = $historyDetailRepo;
    }

    /**
     * Store a newly created HistoryDetail in storage.
     *
     * @param CreateHistoryDetailRequest $request
     *
     * @return Response
     */
    public function store(HistoryDetailRequest $request)
    {
        $input = $request->all();

        //dd($input);

        $input['date'] = Carbon::createFromFormat('d-m-Y H:i', $input['date'])->toDateTimeString();

        $historyDetail = $this->historyDetailRepository->createWithFiles($input, $input['history_id']);

        Flash::success('Detalle de historia clínica guardado correctamente');

        $history_id = $input['history_id'];
        
        return redirect(route('historias.show', ['id' => $history_id]));
    }

    /**
     * Update the specified HistoryDetail in storage.
     *
     * @param  int              $id
     * @param UpdateHistoryDetailRequest $request
     *
     * @return Response
     */
    public function update($id, HistoryDetailRequest $request)
    {
        $input = $request->all();
        
        //dd($input);

        $historyDetail = $this->historyDetailRepository->findWithoutFail($input['detail_id']);

        if (empty($historyDetail)) {
            Flash::error('Detalle de historia clínica no encontrado');
            return redirect(route('historyDetails.index'));
        }
       
        $historyDetail = $this->historyDetailRepository->updateWithFiles($input, $input['detail_id']);
        
        Flash::success('Detalle de historia clínica actualizado correctamente');

        $history_id = $input['history_id'];

        return redirect(route('historias.show', ['id' => $history_id]));
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
        // $historyDetail = $this->historyDetailRepository->findWithoutFail($id);

        // if (empty($historyDetail)) {
        //     Flash::error('Detalle de historia clínica no encontrado');

        //     return redirect(route('historyDetails.index'));
        // }

        // $this->historyDetailRepository->delete($id);

        // Flash::success('Detalle de historia clínica eliminado correctamente');

        // return redirect(route('historyDetails.index'));
    }
}
