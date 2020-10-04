<?php

namespace App\Repositories;

use App\Models\ExceptionDay;

use InfyOm\Generator\Common\BaseRepository;

use App\Helpers\ViewFormatter;

class ExceptionDayRepository extends BaseRepository
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
        return ExceptionDay::class;
    }

    public function createOrUpdate(array $attributes, $id = null){

        $medicalStudies = isset($attributes['medical_studies']) ? $attributes['medical_studies'] : null;

        unset($attributes['medical_studies']);
        
        $exceptionDay = null;
        if($id == null){
            $exceptionDay = parent::create($attributes);
        }else{
            $exceptionDay = parent::update($attributes, $id);
        }
        
        if( $medicalStudies == null || $medicalStudies[0] == 'null') {
            $exceptionDay->medicalStudies()->detach();
        } else {
            $exceptionDay->medicalStudies()->sync($medicalStudies);
        }

        return $exceptionDay;

    }

    public function update(array $attributes, $id){

        $exceptionDay = parent::update($attributes, $id);
        
        if($attributes['medical_studies'][0] == 'null') {
            $exceptionDay->medicalStudies()->detach();
        } else {
            $exceptionDay->medicalStudies()->sync($attributes['medical_studies']);
        }

        return $exceptionDay;

    }

    public function create(array $attributes){

        $exceptionDay = parent::create($attributes);
        
        if($attributes['medical_studies'][0] == 'null') {
            $exceptionDay->medicalStudies()->detach();
        } else {
            $exceptionDay->medicalStudies()->sync($attributes['medical_studies']);
        }

        return $exceptionDay;

    }
}
