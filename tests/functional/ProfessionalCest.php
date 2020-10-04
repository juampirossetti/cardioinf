<?php

use App\Models\Professional;
class ProfessionalCest
{   
    private $url = '/secretary/configuration/professionals';
    
    private $professional = [
        'name' => 'Juan',
        'surname' => 'Perez'
    ];
    
    public function _before(\Step\Functional\Secretary $I)
    {
        $I->loginAsSecretary();
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests alta, baja, modificacion, lectura
    public function createProfessionalTest(FunctionalTester $I)
    {
        $I->am('a Secretary');
        $I->wantTo('register a new professional as a secretary');
        $I->amOnPage($this->url . '/create');
        $I->seeCurrentUrlEquals($this->url . '/create');
        $I->submitForm('#professional-form', $this->professional);
        $I->seeRecord('professionals', $this->professional);
        $I->see('El médico fue guardado correctamente','.alert-success'); 
    }

    public function updateProfessionalTest(FunctionalTester $I)
    {
        $professional = Professional::create($this->professional);

        $I->am('a Secretary');
        $I->wantTo('update professional as a secretary');
        $I->amOnPage($this->url . '/' . $professional->id . '/edit');
        $I->seeInCurrentUrl('edit');
        
        $I->amGoingTo('try to submit with empty surname');
        $I->fillField('surname','');
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('El campo Apellido es obligatorio','.alert-danger');

        $I->amGoingTo('try to submit with empty name');
        $I->fillField('name','');
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('El campo Nombre es obligatorio','.alert-danger');

        $I->amGoingTo('submit with correct values');
        $I->fillField('name','José');
        $I->fillField('surname','Gonzalez');
        $I->click('Guardar');
        $I->seeRecord('professionals', array('name' => 'José', 'surname' => 'Gonzalez'));
        $I->see('Médico actualizado correctamente','.alert-success');

    }

    public function showProfessionalTest(FunctionalTester $I) {
        
        $professional = Professional::create($this->professional);

        $I->am('a Secretary');
        $I->wantTo('view the information of a professional');
        $I->amOnPage($this->url . '/' . $professional->id);
        
        $I->see($professional->surname);
    }

    public function createDuplicateProfessionalTest(FunctionalTester $I)
    {
        //TODO
    }
    
    /* public function deleteProfessionalTest(FunctionalTester $I)
     {
        Test Manual
     }
    */
}
