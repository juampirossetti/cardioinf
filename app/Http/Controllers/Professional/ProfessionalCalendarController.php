<?php

namespace App\Http\Controllers\Professional;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use Auth;

use Flash;

use App\Models\SMConfig;

class ProfessionalCalendarController extends Controller
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
        $user = Auth::user();

        return view('professional_section.calendar.index')
                ->with('user', $user);
    }
}