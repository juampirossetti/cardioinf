<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Repositories\HistoryDetailRepository;

use App\Http\Controllers\AppBaseController;

class ApiHistoryDetailController extends AppBaseController {
    
    /** @var  HistoryDetailRepository */
    private $historyDetailRepository;

    public function __construct(HistoryDetailRepository $historyDetailRepo)
    {
        $this->historyDetailRepository = $historyDetailRepo;
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
            return response()->json(['message' => 'Not Found'], 404);
        }

        $this->historyDetailRepository->deleteWithFiles($id);

        return response()->json([], 201);
    }
};