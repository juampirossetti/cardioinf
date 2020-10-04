<?php

use App\Models\Insurance;

class InsuranceCest
{

    private $url = '/secretary/configuration/insurances';
    
    private $insurance = [
        array(
            'name' => 'Obra Social 1',
            'enabled' => true,
            'description' => 'Descripción de la obra social 1.'
        ),
        array(
            'name' => 'Obra Social 2',
            'enabled' => true,
            'description' => 'Descripción de la obra social 2.'
        )
    ];

    private $new_insurance = [
        'name' => 'Nueva Obra Social',
        'description' => 'Esta es una nueva obra social',
        'enabled' => true
    ];

    public function _before(\Step\Functional\Secretary $I)
    {
        $I->loginAsSecretary();
    }

    public function _after(FunctionalTester $I)
    {
    }
    
    // TESTS
    public function createInsuranceTest(FunctionalTester $I)
    {   
        $I->am('a Secretary');
        $I->wantTo('register a new insurance');
        $I->amOnPage($this->url . '/create');
        $I->submitForm('#insurance-form', $this->insurance[0]);
        $I->seeRecord('insurances', $this->insurance[0]);
        $I->see('La obra social fue guardada correctamente','.alert-success'); 
    }

    public function updateInsuranceTest(FunctionalTester $I)
    {
        $insurance_0 = Insurance::create($this->insurance[0]);
        $insurance_1 = Insurance::create($this->insurance[1]);
    

        $I->am('a Secretary');
        $I->wantTo('update an insurance');
        $I->amOnPage($this->url . '/' . $insurance_0->id . '/edit');
        $I->seeInCurrentUrl('edit');
        
        $I->amGoingTo('try to submit with empty insurance name');        
        $I->fillField('name', '');
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('El campo Nombre es obligatorio','.alert-danger');

        $I->amGoingTo('try to submit an insurance that already exists');        
        $I->amOnPage($this->url . '/' . $insurance_0->id . '/edit');
        $I->fillField('name','Obra Social 2');
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('Este nombre ya fue utilizado.','.alert-danger');

        $I->amGoingTo('update an insurance with new name, enabled and a description');        
        $I->amOnPage($this->url . '/' . $insurance_0->id . '/edit');
        $I->fillField('name',$this->new_insurance['name']);
        $I->fillField('description',$this->new_insurance['description']);
        $I->seeCheckboxIsChecked('#enabled');
        $I->click('Guardar');
        $I->dontSeeInCurrentUrl('edit');
        $I->seeRecord('insurances', $this->new_insurance);

        $I->see('La obra social fue actualizada correctamente', '.alert-success');
    }

    public function disabledAndEnabledInsuranceTest(FunctionalTester $I)
    {
        $I->am('a Secretary');
        $I->wantTo('disable an insurance and check that is not in the list of insurances at new appointment');

        $insurance_0 = Insurance::create($this->insurance[0]);
        $insurance_1 = Insurance::create(
            array_merge($this->insurance[1],['enabled' => false]));

        $I->amGoingTo('see if the disabled insurance is hidden in new appointment');
        $I->amOnPage('/secretary/calendar' );
        $I->seeInSource($insurance_0->name);

        $I->amGoingTo('see if the enabled insurance is shown in new appointment');
        $I->dontSeeInSource($insurance_1->name);
    }

    public function viewInsuranceTest(FunctionalTester $I)
    {
        $I->am('a Secretary');
        $I->wantTo('view the details of an insurance');

        $insurance_0 = Insurance::create($this->insurance[0]);
        $I->amGoingTo('see if the enabled insurance is shown correctly');
        $I->amOnPage($this->url . '/' . $insurance_0->id);
        $I->see($insurance_0->name);
        $I->see('Si','p');

        $insurance_1 = Insurance::create(
            array_merge($this->insurance[1],['enabled' => false]));
        
        $I->amGoingTo('see if the disabled insurance is shown correctly');
        $I->amOnPage($this->url . '/' . $insurance_1->id);
        $I->see($insurance_1->name);
        $I->see('No','p');


    }

    public function createDuplicateInsuranceTest(FunctionalTester $I)
    {   
        $insurance_0 = Insurance::create($this->insurance[0]);
        
        $I->am('a Secretary');
        $I->wantTo('create an insurance with duplicated name');

        $I->amGoingTo('try to submit an insurance that already exists');        
        $I->amOnPage($this->url . '/create');
        $I->fillField('name','Obra Social 1');
        $I->click('Guardar');
        $I->seeInCurrentUrl('create');
        $I->see('Este nombre ya fue utilizado.','.alert-danger');

    }

    // public function deleteInsuranceTest(FunctionalTester $I)
    // {
    //     Test Manual
    // }


}
