<?php

namespace App\Services;

use App\Models\Professional;

use App\Helpers\DatetimeHelper;

use Config;

use Carbon\Carbon;

class ProfessionalService
{
    public function __construct(){
        
    }

    //con professional y medical study
    public function workingDates($professional_id, $medical_study_id = null){
        $professional = Professional::find($professional_id);
        if(empty($professional)){
            return;
        }

        $monthsafter = Config::get('appointment.calendar.showmonthsafter');
        $to = Carbon::now(-3)->addMonths($monthsafter)->format('Y-m-d');

        $monthsbefore = Config::get('appointment.calendar.showmonthsbefore');
        $from = Carbon::now(-3)->subMonths($monthsbefore)->format('Y-m-d');
        
        $dateRange = DatetimeHelper::createRange($from, $to);

        $result = array();
        
        foreach ($dateRange as $date){
            if($medical_study_id == null) {
                if( $professional->worksOn($date->format('Y-m-d')) ){
                    $result[] = $date->format('Y-m-d');
                }
            } else {
                if( $professional->does($medical_study_id, $date->format('Y-m-d')) ){
                    $result[] = $date->format('Y-m-d');
                }
            }
        }

        return $result;

        

    }
}