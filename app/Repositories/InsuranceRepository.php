<?php

namespace App\Repositories;

use App\Models\Insurance;

use App\Models\ProfessionalInsurance;

use InfyOm\Generator\Common\BaseRepository;

use App\Helpers\ViewFormatter;

class InsuranceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Insurance::class;
    }

    /*
     * Get array of insurances in the form [id] => Insurance Name
     */ 
    
    public static function getInsurancesForSelect($include_disables = false){
        if($include_disables) {
            $insurances = Insurance::orderBy('name', 'asc')->get();
        } else {
            $insurances = Insurance::where('enabled', true)->orderBy('name', 'asc')->get();
        }
        return ViewFormatter::getArrayForSelect($insurances, 'id', 'name');
    }

    /*
     * Get list of insurances from a professional.
     * enabled_patient = include insurances enabled for a patient
     */

    public static function getInsurancesForProfessional($professional_id, $enabled_patient){
        $insurances = ProfessionalInsurance::where('professional_id', $professional_id)
                                           ->where('enabled_patient', $enabled_patient)
                                           ->join('insurances', 'insurances.id', '=', 'insurance_id')
                                           ->where('insurances.patient_enabled', '=', true)
                                           ->get();

        return $insurances->sortByDesc('insurance.name');
    }

    public function select2Search($params){
        
        $insurances = \DB::table('insurances')
                        ->where('insurances.name','LIKE','%'.$params.'%')
                        ->select(['insurances.name', 'insurances.id'])->get();
        
        return $insurances;
    }
}
