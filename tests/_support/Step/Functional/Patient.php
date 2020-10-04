<?php
namespace Step\Functional;

class Patient extends \FunctionalTester
{
	private $user_info = [
        'name' => 'Juan',
        'surname' => 'Perez',
        'dni' => '33444555',
        'address' => 'San Martín 123',
        'primary_phone' => '(0342) 4587234',
        'email' => 'patient@tester.com',
        'password' => '123456',
        'password_confirmation' => '123456',
        'role' => 'patient'
    ];

    public function loginAsPatient()
    {
        $I = $this;
        $I->login($this->user_info, $this->user_info['role']);
    }

    public function registerNewPatient()
    {
        $I = $this;
        $I->registerUser($this->user_info, $this->user_info['role']);
    }

}