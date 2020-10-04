<?php

namespace App\Repositories;

use App\Models\Indication;
use InfyOm\Generator\Common\BaseRepository;

class IndicationRepository extends BaseRepository
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
        return Indication::class;
    }

    public function findWithMedicalStudyAndInsurance($medical_study_id, $insurance_id)
    {
        $indication = Indication::where('medical_study_id', $medical_study_id)->where('insurance_id',$insurance_id)->first();

        return $indication;
    }

}