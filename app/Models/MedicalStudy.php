<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class MedicalStudy
 * @package App\Models
 * @version August 7, 2017, 5:34 pm UTC
 */
class MedicalStudy extends Model
{

    public $table = 'medical_studies';


    public $fillable = [
        'name',
        'enabled',
        'patient_enabled',
        'acronym',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'enabled' => 'boolean',
        'patient_enabled' => 'boolean',
        'description' => 'string',
        'acronym' => 'string'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_enabled',
        'is_patient_enabled'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|max:60|required|unique:medical_studies,name',
        'enabled' => 'numeric',
        'patient_enabled' => 'numeric',
        'description' => 'string|nullable',
        'acronym' => 'string|max:10|required'
    ];

    public function isEnabled(){
        return $this->attributes['enabled'];
    }

    public function isPatientEnabled(){
        return $this->attributes['patient_enabled'];
    }

    public function getIsPatientEnabledAttribute(){
        return ($this->attributes['patient_enabled'] == true) ? 'Si' : 'No';
    }

    public function getIsEnabledAttribute($value) {
        return ($this->attributes['enabled'] == true) ? 'Si' : 'No';
    }
}
