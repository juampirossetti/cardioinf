<?php

namespace App\Repositories;

use App\Models\Timetable;
use InfyOm\Generator\Common\BaseRepository;

class TimetableRepository extends BaseRepository
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
        return Timetable::class;
    }

    public function update(array $attributes, $id){

        $timetable = parent::update($attributes, $id);
        
        if($attributes['medical_studies'][0] == 'null') {
            $timetable->medicalStudies()->detach();
        } else {
            $timetable->medicalStudies()->sync($attributes['medical_studies']);
        }

        return $timetable;

    }

    public function create(array $attributes){

        $timetable = parent::create($attributes);
        
        if($attributes['medical_studies'][0] == 'null') {
            $timetable->medicalStudies()->detach();
        } else {
            $timetable->medicalStudies()->sync($attributes['medical_studies']);
        }

        return $timetable;

    }
}
