<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;

use Flash;

use App\Http\Controllers\AppBaseController;

use Response;

use App\Models\SMConfig;

use App\Services\SystemConfigService;

use App\Models\Professional;

class AdminConfigurationController extends AppBaseController
{

    private $tabs = [
        'general' => 0,
        'professional' => 1
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

        return View('admin.config.index', [
                    'configs' => $configs,
                    'active_tab' => '0'
                    ]);
    }

    public function update(Request $request, $section = 'general'){
        
        $input = $request->all();
        
        if(isset($input['max_number_of_professionals'])){
            $professionals = Professional::all();
            //dd(count($professionals));
            if(count($professionals) > $input['max_number_of_professionals'] ){
                
                Flash::error('La cantidad de profesionales no puede ser menor a '.count($professionals).'. Si desea que sea menor debe eliminar algún profesional primero.');
                
                return View('admin.config.index',[
                        'configs' => SMConfig::getAll(),
                        'active_tab' => $this->tabs[$section]
                        ]);
            }
        }

        $this->systemConfigService->updateAll($input);

        $configs = SMConfig::getAll();

        return View('admin.config.index', [
                    'configs' => $configs,
                    'active_tab' => $this->tabs[$section]
                    ]);


    }
}