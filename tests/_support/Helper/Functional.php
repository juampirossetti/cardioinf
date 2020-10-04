<?php
namespace Helper;

use App\Models\User;
use App\Models\Role;
use App\Models\Patient;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Functional extends \Codeception\Module
{
	public function registerUser($user_info, $role) {
		
		$role = Role::where('name', $role)->first();

		$user = factory(User::class)->create([
			'name' => $user_info['name'],
			'email' => $user_info['email'],
			'password' => bcrypt($user_info['password'])]);
		
		$patient = Patient::create(
			['name' => $user_info['name'],
             'surname' => $user_info['surname'],
             'dni' => $user_info['dni']
            ]);
        
        $user->attachRole($role);
        $user->patient_id = $patient->id;
		$user->save();

	}

	public function removeUser($email) {
		$user = User::where('email',$email)->first();
		$user->delete();
	}
}
