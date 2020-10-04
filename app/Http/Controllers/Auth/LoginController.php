<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    
    protected function authenticated(Request $request, $user)
    {
        if ( $user->hasRole('admin') ) {
            return redirect('admin/users');
        }
        if ( $user->hasRole('secretary') ) {
            return redirect('secretary/calendar');
        }
        if ( $user->hasRole('patient') ) {
            return redirect('patient/appointments');
        }
        if ( $user->hasRole('professional') ) {
            return redirect('professional/calendar');
        }

        return redirect('/');
    }
}
