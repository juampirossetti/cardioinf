<?php

class LoginCest
{

    private $user_info = [
        'name' => 'Juan',
        'surname' => 'Perez',
        'dni' => '33444555',
        'address' => 'San Martín 123',
        'primary_phone' => '(0342) 4587234',
        'email' => 'patient@tester.com',
        'password' => '123456',
        'password_confirmation' => '123456'
    ];

    // TESTS
        
    public function registerTest(FunctionalTester $I)
    {
       $I->wantTo('register a new patient');
       $I->amOnPage('/login');
       $I->click('#register');
       $I->amOnPage('/register');
       $I->submitForm('.login-form', $this->user_info);

       $I->see('Sus próximos turnos');
    }
    
    public function loginAsPatientTest(\Step\Functional\Patient $I)
    {
        $I->registerNewPatient();
        $I->loginAsPatient();
        $I->amOnPage('/patient/appointments');
        $I->see('Sus próximos turnos');
    }

    public function loginAsSecretaryTest(\Step\Functional\Secretary $I)
    {
        $I->loginAsSecretary();
        $I->amOnPage('/secretary/calendar');
        $I->see('Secretary','p');
    }

    public function loginAsAdminTest(\Step\Functional\Admin $I)
    {
        $I->loginAsAdmin();
        $I->amOnPage('/admin/users');
        $I->see('Usuarios');
    }
}
