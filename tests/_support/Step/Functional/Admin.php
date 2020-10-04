<?php
namespace Step\Functional;

class Admin extends \FunctionalTester
{
	private $user_info = [
        'name' => 'Admin',
        'email' => 'juanpablo@girosit.com',
        'password' => 'awesome',
        'password_confirmation' => 'awesome',
        'role' => 'admin'
    ];

    public function loginAsAdmin()
    {        
        $I = $this;
        $I->login($this->user_info, $this->user_info['role']);
    }
}