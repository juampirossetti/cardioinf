<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\AppBaseController;

class SupportController extends AppBaseController
{
    
    public function __construct()
    {
        
    }

    /**
     * Display support page.
     *
     * 
     */
    public function index()
    {
        return view('support.index');
    }
}
