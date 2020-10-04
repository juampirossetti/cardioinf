<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Patient;

use App\Models\Card;

use App\Models\Professional;

use App\Repositories\CardRepository;

use App\Http\Requests\CardRequest;

use Yajra\Datatables\Datatables;

use Flash;

class CardController extends Controller
{
    private $cardRepository;

    public function __construct(CardRepository $cardRepo)
    {
        $this->cardRepository = $cardRepo; 
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function cardsData(Request $request)
    {   
        $query = Card::query();
        
        if($request->has('patient_id')){
            $query = $query->where('patient_id', $request->patient_id);
        }
        
        return Datatables::of($query)->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient, Card $card)
    {
        if(!$patient->cards->pluck('id')->contains($card->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('patients.index'));
        }

        $professionals = Professional::all();

        return view('patients.cards.edit')
            ->with('card', $card)
            ->with('professionals', $professionals);
    }

    /**
     * Show the form for creating a new Card.
     *
     * @return Response
     */
    public function create(Patient $patient)
    {
        $professionals = Professional::all();
        return view('patients.cards.create')
            ->with('patient',$patient)
            ->with('professionals', $professionals);
    }

    /**
     * Store a newly created History in storage.
     *
     * @param CreateHistoryRequest $request
     *
     * @return Response
     */
    public function store(Patient $patient, CardRequest $request)
    {
        $input = $request->all();

        $card = $this->cardRepository->create($input);

        Flash::success('Ficha guardada correctamente');

        return redirect(route('patients.show', $patient->id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Patient $patient, Card $card, CardRequest $request)
    {
        if(!$patient->cards->pluck('id')->contains($card->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('patients.index'));
        }

        $card = $this->cardRepository->update($request->all(), $card->id);

        Flash::success('La ficha fue actualizada correctamente.');

        return redirect(route('patients.show', $patient->id));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient, Card $card)
    {
        if(!$patient->cards->pluck('id')->contains($card->id)){
            Flash::error('Consulta incorrecta. Por favor intente nuevamente.');

            return redirect(route('patients.index'));
        }

        $card->delete();

        Flash::success('La ficha fue eliminada correctamente');

        return redirect()->back();
    }
}
