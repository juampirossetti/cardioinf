<?php
namespace Step\Functional;

class Secretary extends \FunctionalTester
{
	private $user_info = [
        'name' => 'Secretary',
        'email' => 'secretary@girosit.com',
        'password' => 'awesome',
        'password_confirmation' => 'awesome',
        'role' => 'secretary'
    ];

    public function loginAsSecretary()
    {        
        $I = $this;
        $I->login($this->user_info, $this->user_info['role']);
    }

}