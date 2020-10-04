<?php

namespace App\Http\Controllers;

use App\DataTables\PatientHistoryDataTable;
use App\Http\Requests;
use App\Http\Requests\PatientHistoryRequest;
use App\Repositories\PatientHistoryRepository;

use App\Repositories\AuditoriaRepository;

use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

use Session;

use Illuminate\Http\Request;

use Auth;

use Carbon\Carbon;

class PatientHistoryController extends AppBaseController
{
    /** @var  HistoryRepository */
    private $patientHistoryRepository;

    private $auditoriaRepository;

    public function __construct(
        PatientHistoryRepository $patientHistoryRepo, 
        AuditoriaRepository $auditoriaRepo)
    {
        $this->patientHistoryRepository = $patientHistoryRepo;
        $this->auditoriaRepository = $auditoriaRepo;
    }

    /**
     * Display a listing of the History.
     *
     * @param HistoryDataTable $historyDataTable
     * @return Response
     */
    public function index(Request $request, PatientHistoryDataTable $patientHistoryDataTable)
    {   
        $user = Auth::user();

        //if(count($user->professional)){
        if($user->professional){
            $professional_id = $user->professional->id;
        } else {
            $professional_id = null;
        }

        // Descomentar esto y comentar la linea con 'null' para volver a filtrar historias por profesional
        //$patientHistoryDataTable = $patientHistoryDataTable->with('professional_id', $professional_id); 
        $patientHistoryDataTable = $patientHistoryDataTable->with('professional_id', null);

        if($request->has('search')){
            $search = $request->get('search');
        } else {
            $search = "";
        };

        return $patientHistoryDataTable->render('patients_histories.index',['search' => $search]);
    }

    /**
     * Show the form for creating a new History.
     *
     * @return Response
     */
    public function create()
    {
        $user = Auth::user();

        $professional_id = null;
        
        if($user->professional){
            $professional_id = $user->professional->id;
        };
        
        //if(count($user->professional)){
        //    $professional_id = $user->professional->id;
        //};
        
        return view('patients_histories.create')
            ->with('professional_id', $professional_id)
            ->with('user', $user);
    }

    /**
     * Store a newly created History in storage.
     *
     * @param CreateHistoryRequest $request
     *
     * @return Response
     */
    public function store(PatientHistoryRequest $request)
    {
        $input = $request->all();
        
        if ( isset($input['professional_id']) && $input['professional_id'] == '' )
            $input['professional_id'] = null;

        $history = $this->patientHistoryRepository->create($input);

        $data = $history->makeHidden('os')->toJson();        
        //auditoria
        $this->auditoriaRepository->create([
            'date' => Carbon::now(-3),
            'category' => 'Creacion de historia',
            'content' => 'El usuario '. Auth::user()->email .' creó la historia número'. $history->id .'. Datos: '. $data
        ]);
        //end-auditoria

        Flash::success('Ahora puedes comenzar a editar esta historia clínica.');

        return redirect(route('historias.show',['id' => $history->id]));
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
        $user = Auth::user();

        $history = $this->patientHistoryRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('historias.index'));
        }
        

        Session::flash('backUrl', request()->fullUrl());

        return view('patients_histories.show')
            ->with('history', $history)
            ->with('user', $user);
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
        $user = Auth::user();

        $history = $this->patientHistoryRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('historias.index'));
        }

        if (Session::has('backUrl')) {
           Session::keep('backUrl');
        }

        $professional_id = $history->professional_id;
        return view('patients_histories.edit')
            ->with('history', $history)
            ->with('professional_id', $professional_id)
            ->with('user', $user);
    }

    /**
     * Update the specified History in storage.
     *
     * @param  int              $id
     * @param UpdateHistoryRequest $request
     *
     * @return Response
     */
    public function update($id, PatientHistoryRequest $request)
    {
        // dd($request->all());
        $history = $this->patientHistoryRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('historias.index'));
        }

        $input = $request->all();

        if ( isset($input['professional_id']) && $input['professional_id'] == '' )
            $input['professional_id'] = null;
        
        $oldData = $history->makeHidden('os')->toJson();

        $history = $this->patientHistoryRepository->update($input, $id);

        $newData = $history->makeHidden('os')->toJson();

        //auditoria
        $this->auditoriaRepository->create([
            'date' => Carbon::now(-3),
            'category' => 'Cambio de historia',
            'content' => 'El usuario '. Auth::user()->email .' modificó la historia número'. $history->id .'. Datos anteriores: '. $oldData .'. Datos nuevos: '. $newData
        ]);
        //end-auditoria

        Flash::success('Historia clínica actualizada correctamente');

        return ($url = Session::get('backUrl')) 
            ? redirect()->to($url) 
            : redirect()->route('historias.index');

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
        $history = $this->patientHistoryRepository->findWithoutFail($id);

        if (empty($history)) {
            Flash::error('Historia clínica no encontrada');

            return redirect(route('historias.index'));
        }

        $oldData = $history->makeHidden('os')->toJson();
        $id = $history->id;
        $this->patientHistoryRepository->delete($id);
        
        //auditoria
        $this->auditoriaRepository->create([
            'date' => Carbon::now(-3),
            'category' => 'Eliminacion de historia',
            'content' => 'El usuario '. Auth::user()->email .' eliminó la historia número'. $id .'. Datos anteriores: '. $oldData
        ]);
        //end-auditoria


        Flash::success('Historia clínica eliminada correctamente');

        return redirect(route('historias.index'));
    }
}
