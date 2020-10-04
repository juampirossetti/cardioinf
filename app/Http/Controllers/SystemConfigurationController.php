<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use Flash;

use App\Http\Controllers\AppBaseController;

use Response;

use App\Models\SMConfig;

use App\Services\SystemConfigService;

class SystemConfigurationController extends AppBaseController
{

    private $days = [
        'Lunes', 'Martes', 'Miércoles',
        'Jueves', 'Viernes', 'Sábado', 
        'Domingo'];

    private $tabs = [
        'general' => 0,
        'calendar' => 1,
        'patient' => 2,
        'appointment' => 3
    ];

    private $systemConfigService;

    public function __construct(systemConfigService $systemConfigServ)
    {
        $this->systemConfigService = $systemConfigServ;
    }

    /**
     * Display a listing of the Configs.
     */
    public function index()
    {
        $configs = SMConfig::getAll();

        //dd($configs);

        return View('config.index', [
                    'configs' => $configs,
                    'days' => $this->days,
                    'active_tab' => '0'
                    ]);
    }

    public function update(Request $request, $section = 'general'){
        
        $input = $request->all();
        
        //dd($input);
        if($request->hasFile('logo')){
            $path = $request->file('logo')->storeAs('images/logo', 'logo_login');
        }
        
        $this->systemConfigService->updateAll($input);

        $configs = SMConfig::getAll();

        return View('config.index', [
                    'configs' => $configs,
                    'days' => $this->days,
                    'active_tab' => $this->tabs[$section]
                    ]);


    }
}