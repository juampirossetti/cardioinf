<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Controllers\AppBaseController;

use App\Models\SMConfig;

use App\Services\SystemConfigService;

class ApiConfigCalendarController extends AppBaseController {

    private $systemConfigService;

    public function __construct(SystemConfigService $systemConfigServ){

        $this->systemConfigService = $systemConfigServ;
    
    }
    
    public function minMaxTime() {

        $hours = $this->systemConfigService->getMinMaxHours();
        
        return response()->json($hours, 201);
    }
};