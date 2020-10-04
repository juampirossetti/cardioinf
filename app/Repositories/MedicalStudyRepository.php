<?php

namespace App\Repositories;

use App\Models\MedicalStudy;
use InfyOm\Generator\Common\BaseRepository;

use App\Helpers\ViewFormatter;

class MedicalStudyRepository extends BaseRepository
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
        return MedicalStudy::class;
    }

        /*
     * Get array of insurances in the form [id] => Insurance Name
     */ 
    public static function getStudiesForSelect($include_disables = false){
        if($include_disables) {
            $medicalStudies = MedicalStudy::all();
        } else {
            $medicalStudies = MedicalStudy::where('enabled', true)->get();
        }
        return ViewFormatter::getArrayForSelect($medicalStudies, 'id', 'name');
    }
}
