<?php

use App\Models\Patient;

class PatientCest
{
    private $url = '/secretary/patients';
    
    private $patient = [
        array(
            'name' => 'Martin',
            'surname' => 'Lopez',
            'dni' => '21456789',
            'address' => 'Juan de Garay 123',
            'primary_phone' => '(0342) 123456',
            'secondary_phone' => '0341-44567',
            'insurance_id' => null,
            'plan' => null
        ),
        array(
            'name' => 'Juan',
            'surname' => 'Perez',
            'dni' => '34567897',
            'address' => 'San Martin 123',
            'primary_phone' => '0342 156165123',
            'secondary_phone' => '0341 4578674',
            'insurance_id' => null,
            'plan' => null
        ),
    ];

    private $new_patient = [
        'name' => 'Mariano',
        'surname' => 'Suarez',
        'dni' => '21456789',
        'address' => 'San Lorenzo 123',
        'primary_phone' => '(0343) 121156',
        'secondary_phone' => '(0341) 4237',
        'insurance_id' => null,
        'plan' => null
    ];
    // private $professional = [
    //     'name' => 'Juan',
    //     'surname' => 'Perez'
    // ];

    public function _before(\Step\Functional\Secretary $I)
    {
        $I->loginAsSecretary();
    }

    public function _after(FunctionalTester $I)
    {
    }

    // TESTS
    public function createPatientTest(FunctionalTester $I)
    {   
        $I->am('a Secretary');
        $I->wantTo('register a new patient');
        $I->amOnPage($this->url . '/create');
        $I->submitForm('#patient-form', $this->patient[0]);
        $I->seeRecord('patients', $this->patient[0]);
        $I->see('El paciente fue guardado correctamente','.alert-success'); 
    }

    public function updateInsuranceTest(FunctionalTester $I)
    {
        $patient_0 = Patient::create($this->patient[0]);
        $patient_1 = Patient::create($this->patient[1]);
    

        $I->am('a Secretary');
        $I->wantTo('update a patient');
        $I->amOnPage($this->url . '/' . $patient_0->id . '/edit');
        $I->seeInCurrentUrl('edit');
        
        $I->amGoingTo('try to submit with empty patient name');        
        $I->fillField('name', '');
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('El campo Nombre es obligatorio','.alert-danger');

        $I->amGoingTo('try to submit a patient that already exists');        
        $I->amOnPage($this->url . '/' . $patient_0->id . '/edit');
        $I->fillField('dni',$patient_1->dni);
        $I->click('Guardar');
        $I->seeInCurrentUrl('edit');
        $I->see('Este dni ya se encuentra registrado.','.alert-danger');

        $I->amGoingTo('update a patient with new information');        
        $I->amOnPage($this->url . '/' . $patient_0->id . '/edit');
        $I->fillField('name',$this->new_patient['name']);
        $I->fillField('surname',$this->new_patient['surname']);
        $I->fillField('address',$this->new_patient['address']);
        $I->fillField('primary_phone',$this->new_patient['primary_phone']);
        $I->fillField('secondary_phone',$this->new_patient['secondary_phone']);
        $I->selectOption('insurance_id','Seleccionar');
        $I->fillField('plan',$this->new_patient['plan']);

        $I->click('Guardar');
        $I->dontSeeInCurrentUrl('edit');
        $I->seeRecord('patients', $this->new_patient);

        $I->see('El paciente fue actualizado correctamente', '.alert-success');
    }
}
