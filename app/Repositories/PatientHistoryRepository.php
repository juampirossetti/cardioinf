<?php

namespace App\Repositories;

use App\Models\History;
use InfyOm\Generator\Common\BaseRepository;

class PatientHistoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'professional_id',
        'patient_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return History::class;
    }

    public function where($column ,$value){
        return History::where($column, $value)->get();
    }

}
