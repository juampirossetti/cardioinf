<?php

namespace App\Repositories;

use App\Models\ProfessionalInsurance;

use InfyOm\Generator\Common\BaseRepository;

class ProfessionalInsuranceRepository extends BaseRepository
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
        return ProfessionalInsurance::class;
    }

    public function findWithoutFailWithInsuranceID($professional_id, $insurance_id){
        $results = ProfessionalInsurance::where('professional_id', $professional_id)
                                        ->where('insurance_id', $insurance_id)
                                        ->first();
        return $results;
    }
}