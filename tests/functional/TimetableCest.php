<?php

use App\Models\Professional;
use App\Models\Timetable;

class TimetableCest
{
    private $url = '/secretary/configuration/timetables';
    
    private $timetable = [
        array(
            'day' => '1',
            'turn' => '0',
            'from' => '07:00',
            'until' => '12:00',
            'delta' => '0:15'
        ),
        array(
            'day' => '1',
            'turn' => '1',
            'from' => '15:00',
            'until' => '19:00',
            'delta' => '0:15'
        )
    ];

    private $professional;

    public function _before(\Step\Functional\Secretary $I)
    {
        $this->professional = Professional::create([
            'name' => 'Juan',
            'surname' => 'Perez'
        ]);

        $this->timetable[0]['professional_id'] = $this->professional->id;
        $this->timetable[1]['professional_id'] = $this->professional->id;

        $I->loginAsSecretary();
    }

    public function _after(FunctionalTester $I)
    {
    }

    // TESTS

    public function createTimetableTest(FunctionalTester $I)
    {
        $I->am('a Secretary');
        $I->wantTo('register a new timetable');
        $I->amOnPage($this->url . '/create');
        $I->submitForm('#timetable-form', $this->timetable[0]);
        $I->seeRecord('timetables', $this->timetable[0]);
        $I->see('El horario de atención fue guardado correctamente','.alert-success'); 
    }

    public function updateTimetableTest(FunctionalTester $I)
    {
        $timetable_0 = Timetable::create($this->timetable[0]);
        $timetable_1 = Timetable::create($this->timetable[1]);
    

        $I->am('a Secretary');
        $I->wantTo('update a timetable');
        $I->amOnPage($this->url . '/' . $timetable_0->id . '/edit');
        $I->seeInCurrentUrl('edit');
        
        $I->amGoingTo('try to submit with empty professional');        
        $option = $I->grabTextFrom('select[name=professional_id] option:nth-child(1)');
        $I->selectOption("professional_id", $option);        
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('Debe seleccionar un médico de la lista','.alert-danger');

        $I->amGoingTo('try to submit a day and turn that already exists');        
        $I->amOnPage($this->url . '/' . $timetable_0->id . '/edit');
        $option = $I->grabTextFrom('select[name=turn] option:nth-child(2)');
        $I->selectOption("turn", $option);        
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('La combinación de Día, Turno, Médico ya existe','.alert-danger');

        $I->amGoingTo('try to submit a new time between turns, from time and until time');        
        $I->amOnPage($this->url . '/' . $timetable_0->id . '/edit');
        $I->fillField('from', '10:00');
        $I->fillField('until', '11:00');
        $I->fillField('delta', '00:25');
        $I->click('Guardar');
        $I->seeRecord('timetables', array(
            'from' => '10:00', 
            'until' => '11:00',
            'delta' => '00:25',
            'id' => $timetable_0->id));
        $I->see('El horario de atención fue actualizado correctamente','.alert-success');    
    }

    public function showTimetableTest(FunctionalTester $I) {
        
        $timetable = Timetable::create($this->timetable[0]);

        $I->am('a Secretary');
        $I->wantTo('view the information of a timetable');
        $I->amOnPage($this->url . '/' . $timetable->id);
        
        $I->see($timetable->day);
        $I->see($timetable->turn);
        $I->see($this->professional->surname);
    }

    //public function deleteTimetableTest(FunctionalTester $I) {
        //Test manual
    //}
}
