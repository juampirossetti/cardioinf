<?php

namespace App\Repositories;

use App\Models\Professional;
use InfyOm\Generator\Common\BaseRepository;

use App\Helpers\ViewFormatter;

class ProfessionalRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'surname',
        'internal_id',
        'enabled',
        'patient_enabled'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Professional::class;
    }

    /*
     * Get array of professionals in the form [id] => Name Surname
     */
    public static function getProfessionalsForSelect($profile = null){
        $professionals = null;
        
        if($profile == 'secretary'){
            $professionals = Professional::where('enabled',true)->get();
        } elseif($profile == 'patient'){
            $professionals = Professional::where('patient_enabled',true)->get();
        }else{
            $professionals = Professional::all();
        }
        return ViewFormatter::getArrayForSelect($professionals, 'id', 'name', 'surname');
    }

    public function createOrUpdate(array $attributes, $id = null){

        $medicalStudies = isset($attributes['medical_studies']) ? $attributes['medical_studies'] : null;
        $insurances = isset($attributes['insurances']) ? $attributes['insurances'] : null;
        
        unset($attributes['insurances']);
        unset($attributes['medical_studies']);
        
        if($id == null){
            $professional = parent::create($attributes);
        }else{
            $professional = parent::update($attributes, $id);
        }
        
        if( $medicalStudies == null || $medicalStudies[0] == 'null') {
            $professional->medicalStudies()->detach();
        } else {
            $professional->medicalStudies()->sync($medicalStudies);
        }

        if($insurances == null || $insurances[0] == 'null') {
            $professional->insurances()->detach();
        } else {
            $professional->insurances()->sync($insurances);
        }

        return $professional;

    }
}
