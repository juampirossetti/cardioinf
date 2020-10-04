<?php

namespace App\Http\Controllers;

use App\DataTables\InsuranceDataTable;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateInsuranceRequest;
use App\Http\Requests\UpdateInsuranceRequest;
use App\Repositories\InsuranceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class InsuranceController extends AppBaseController
{
    /** @var  InsuranceRepository */
    private $insuranceRepository;

    public function __construct(InsuranceRepository $insuranceRepo)
    {
        $this->insuranceRepository = $insuranceRepo;
    }

    /**
     * Display a listing of the Insurance.
     *
     * @param InsuranceDataTable $insuranceDataTable
     * @return Response
     */
    public function index(Request $request, InsuranceDataTable $insuranceDataTable)
    {   
        foreach($request->all() as $filter => $value){
            $insuranceDataTable = $insuranceDataTable->with($filter, $value);
        }
        return $insuranceDataTable->render('insurances.index', ['data' => $request->all()]);
    }

    /**
     * Show the form for creating a new Insurance.
     *
     * @return Response
     */
    public function create()
    {
        return view('insurances.create');
    }

    /**
     * Store a newly created Insurance in storage.
     *
     * @param CreateInsuranceRequest $request
     *
     * @return Response
     */
    public function store(CreateInsuranceRequest $request)
    {
        $input = $request->all();

        $insurance = $this->insuranceRepository->create($input);

        Flash::success('La obra social fue guardada correctamente');

        return redirect(route('insurances.index'));
    }

    /**
     * Display the specified Insurance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $insurance = $this->insuranceRepository->findWithoutFail($id);

        if (empty($insurance)) {
            Flash::error('La obra social no fue encontrada');

            return redirect(route('insurances.index'));
        }

        return view('insurances.show')->with('insurance', $insurance);
    }

    /**
     * Show the form for editing the specified Insurance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $insurance = $this->insuranceRepository->findWithoutFail($id);

        if (empty($insurance)) {
            Flash::error('La obra social no fue encontrada');

            return redirect(route('insurances.index'));
        }

        return view('insurances.edit')->with('insurance', $insurance);
    }

    /**
     * Update the specified Insurance in storage.
     *
     * @param  int              $id
     * @param UpdateInsuranceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateInsuranceRequest $request)
    {
        $insurance = $this->insuranceRepository->findWithoutFail($id);

        if (empty($insurance)) {
            Flash::error('La obra social no fue encontrada');

            return redirect(route('insurances.index'));
        }

        $insurance = $this->insuranceRepository->update($request->all(), $id);

        Flash::success('La obra social fue actualizada correctamente');

        return redirect(route('insurances.index'));
    }

    /**
     * Remove the specified Insurance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $insurance = $this->insuranceRepository->findWithoutFail($id);

        if (empty($insurance)) {
            Flash::error('La obra social no fue encontrada');

            return redirect(route('insurances.index'));
        }

        $this->insuranceRepository->delete($id);

        Flash::success('La obra social fue eliminada correctamente');

        return redirect(route('insurances.index'));
    }
}
