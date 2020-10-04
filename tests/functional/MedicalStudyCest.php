<?php

use App\Models\MedicalStudy;

class MedicalStudyCest
{
    private $url = '/secretary/configuration/medicalStudies';
    
    private $medicalStudies = [
        array(
            'name' => 'Estudio médico 1',
            'enabled' => true,
            'description' => 'Descripción del estudio médico 1.'
        ),
        array(
            'name' => 'Estudio médico 2',
            'enabled' => true,
            'description' => 'Descripción del estudio médico 2.'
        )
    ];

    private $new_medicalStudy = [
        'name' => 'Nuevo Estudio Médico',
        'description' => 'Esto es un nuevo estudio médico',
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
    public function createMedicalStudyTest(FunctionalTester $I)
    {   
        $I->am('a Secretary');
        $I->wantTo('register a new medical study');
        $I->amOnPage($this->url . '/create');
        $I->submitForm('#medical-study-form', $this->medicalStudies[0]);
        $I->seeRecord('medical_studies', $this->medicalStudies[0]);
        $I->see('El estudio médico fue guardado correctamente','.alert-success'); 
    }

    public function updateMedicalStudyTest(FunctionalTester $I)
    {
        $medicalStudy_0 = MedicalStudy::create($this->medicalStudies[0]);
        $medicalStudy_1 = MedicalStudy::create($this->medicalStudies[1]);
    

        $I->am('a Secretary');
        $I->wantTo('update a medical study');
        $I->amOnPage($this->url . '/' . $medicalStudy_0->id . '/edit');
        $I->seeInCurrentUrl('edit');
        
        $I->amGoingTo('try to submit with empty study name');        
        $I->fillField('name', '');
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('El campo Nombre es obligatorio','.alert-danger');

        $I->amGoingTo('try to submit a medical study that already exists');        
        $I->amOnPage($this->url . '/' . $medicalStudy_0->id . '/edit');
        $I->fillField('name','Estudio médico 2');
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('Este nombre ya fue utilizado.','.alert-danger');

        $I->amGoingTo('update a medical study with new name, enabled and a description');        
        $I->amOnPage($this->url . '/' . $medicalStudy_0->id . '/edit');
        $I->fillField('name',$this->new_medicalStudy['name']);
        $I->fillField('description',$this->new_medicalStudy['description']);
        $I->seeCheckboxIsChecked('#enabled');
        $I->click('Guardar');
        $I->dontSeeInCurrentUrl('edit');
        $I->seeRecord('medical_studies', $this->new_medicalStudy);

        $I->see('El estudio médico fue actualizado correctamente', '.alert-success');
    }

    public function disabledAndEnabledMedicalStudyTest(FunctionalTester $I)
    {
        $I->am('a Secretary');
        $I->wantTo('disabled a meidcal study and check that is not in the list of medical studies at new appointment');

        $medicalStudy_0 = MedicalStudy::create($this->medicalStudies[0]);
        $medicalStudy_1 = MedicalStudy::create(
            array_merge($this->medicalStudies[1],['enabled' => false]));

        $I->amGoingTo('see if the disabled medical study is hidden in new appointment');
        $I->amOnPage('/secretary/calendar' );
        $I->seeInSource($medicalStudy_0->name);

        $I->amGoingTo('see if the enabled medical study is shown in new appointment');
        $I->dontSeeInSource($medicalStudy_1->name);
    }

    public function viewMedicalStudyTest(FunctionalTester $I)
    {
        $I->am('a Secretary');
        $I->wantTo('view the details of a medical study');

        $medicalStudy_0 = MedicalStudy::create($this->medicalStudies[0]);
        $I->amGoingTo('see if the enabled medical study is shown correctly');
        $I->amOnPage($this->url . '/' . $medicalStudy_0->id);
        $I->see($medicalStudy_0->name);
        $I->dontSee('Id','label');
        $I->see('Si','p');

        $medicalStudy_1 = MedicalStudy::create(
            array_merge($this->medicalStudies[1],['enabled' => false]));
        
        $I->amGoingTo('see if the disabled medical study is shown correctly');
        $I->amOnPage($this->url . '/' . $medicalStudy_1->id);
        $I->see($medicalStudy_1->name);
        $I->dontSee('Id','label');
        $I->see('No','p');


    }

    public function createDuplicateMedicalStudyTest(FunctionalTester $I)
    {   
        $medicalStudy_0 = MedicalStudy::create($this->medicalStudies[0]);
        
        $I->am('a Secretary');
        $I->wantTo('create a medical study with duplicated name');

        $I->amGoingTo('try to submit a medical study that already exists');        
        $I->amOnPage($this->url . '/create');
        $I->fillField('name','Estudio médico 1');
        $I->click('Guardar');
        $I->seeInCurrentUrl('create');
        $I->see('Este nombre ya fue utilizado.','.alert-danger');

    }

}
