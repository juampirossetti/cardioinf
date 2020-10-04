<?php

namespace App\Http\Controllers\Professional;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Auth;

use Flash;

use App\Models\SMConfig;

class DashboardController extends Controller
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
    public function index(Request $request)
    {   
        if(!SMConfig::getByKey('professional_section_enabled')) {
            Auth::logout();

            return redirect('/login')
                ->with('message', 'Los profesionales no estan habilitados para iniciar sesión. Cambie su membresía para acceder al panel de profesionales.');
        }

        return view('professional_section.dashboard');
    }
}