<?php

namespace App\Services;

use App\Models\SMConfig;

class SystemConfigService
{
    public function __construct(){
        
    }

    //con professional y medical study
    public function updateAll($configs){
        
        if(isset($configs['calendar'])){
            $configs['start_hours'] = implode(',', $configs['calendar']['start']);
            $configs['end_hours'] = implode(',', $configs['calendar']['end']);
            unset($configs['calendar']);
        }
        foreach($configs as $name => $value){
            $configuration = SMConfig::where('key', $name)->first();
            if(!empty($configuration)){
                $configuration->value = $value;
                $configuration->save();
            }
        }      

    }

    public function saveLogo($path){
        dd($path);
    }

    public function getMinMaxHours(){

        $minTimes = SMConfig::getByKey('start_hours');
        $minTimes = explode(',',str_replace(' ', '', $minTimes)); //0 -> Lunes
        
        $maxTimes = SMConfig::getByKey('end_hours');
        $maxTimes = explode(',',str_replace(' ', '', $maxTimes)); //0 -> Lunes

        $array[0] = [$minTimes[6].':00',$maxTimes[6].':00']; // 0 -> Domingo
        
        for( $i=0 ; $i<6 ; $i++ ){
            $array[$i+1]=[$minTimes[$i].':00',$maxTimes[$i].':00'];
        }
        
        return $array;
    }
}