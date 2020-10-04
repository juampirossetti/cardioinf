<?php

namespace App\Repositories;

use App\Models\PatientInsurance;

use InfyOm\Generator\Common\BaseRepository;

class PatientInsuranceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PatientInsurance::class;
    }

    public function findWithoutFailWithInsuranceID($patient_id, $insurance_id){
        $results = PatientInsurance::where('patient_id', $patient_id)
                                        ->where('insurance_id', $insurance_id)
                                        ->first();
        return $results;
    }
}