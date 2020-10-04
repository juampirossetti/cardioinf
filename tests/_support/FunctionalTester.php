<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

   /**
    * Define custom actions here
    */
   public function login($user_info, $role) {
   		
   		$I = $this;
   		$I->wantTo('login to the site with role ' . $role);
   		$I->amOnPage('/login');
   		$I->submitForm('#login-form', [
            'email' => $user_info['email'],
            'password' => $user_info['password']
        ]);
   }
}
