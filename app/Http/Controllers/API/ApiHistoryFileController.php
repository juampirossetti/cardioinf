<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Repositories\HistoryFileRepository;

use App\Http\Controllers\AppBaseController;

class ApiHistoryFileController extends AppBaseController {
    
    /** @var  HistoryFileRepository */
    private $historyFileRepository;

    public function __construct(HistoryFileRepository $historyFileRepo)
    {
        $this->historyFileRepository = $historyFileRepo;
    }

    /**
     * Remove the specified HistoryFile from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {   
        $historyFile = $this->historyFileRepository->findWithoutFail($id);
    
        if (empty($historyFile)) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $this->historyFileRepository->deleteFile($id);

        return response()->json([], 201);
    }
};