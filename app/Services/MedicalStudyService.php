<?php

namespace App\Services;

use App\Models\MedicalStudy;

use DB;

class MedicalStudyService
{
    public function __construct(){
        
    }

    //Determinar Insurances por las cuales se puede hacer un determinado tipo de consulta.
    public function getInsurancesAvailables($ms_id, $enabled = true, $patient_enabled = true){

        $insurances = \DB::table('insurances')
                        ->where('insurances.enabled', $enabled)
                        ->where('insurances.patient_enabled', $patient_enabled)
                        ->join('professional_insurance', 'insurances.id', '=', 'professional_insurance.insurance_id')
                        ->join('professional_study', 'professional_insurance.professional_id', '=', 'professional_study.professional_id')
                        ->where('professional_study.medical_study_id', $ms_id)
                        ->select('insurances.id', 'insurances.name')
                        ->groupBy('insurances.id')
                        ->orderBy('insurances.name')
                        ->get();

        return $insurances;

    }

    public function getInsurancesAvailablesArray($ms_id, $enabled = true, $patient_enabled = true){    
        
        $results = $this->getInsurancesAvailables($ms_id, $enabled, $patient_enabled);
        
        $array = array();

        foreach($results as $r){
            $array[$r->id] = $r->name;
        }

        return $array;

    }
}