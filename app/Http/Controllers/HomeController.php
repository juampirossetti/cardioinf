<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        if (Auth::check()) {
            $user = Auth::user();

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
        }else{
            return redirect('login');
        }
    }
}
