<?php

namespace App\Models;

use App\Models\BaseModel as Model;

/**
 * Class PatientInsurance
 * @package App\Models
 * @version May 24, 2017, 11:18 pm UTC
 */
class PatientInsurance extends Model
{
    public $table = 'patients_insurances';
    
    public $fillable = [
        'patient_id',
        'insurance_id',
        'plan',
        'number'
    ];

    /*
     * Hidden attributes for json responses
     */
    public static $hiddenJson = [
        'updated_at',
        'created_at'
        ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'patient_id' => 'integer',
        'insurance_id' => 'integer',
        'plan' => 'string',
        'number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_id' => 'numeric|exists:patients,id',
        'insurance_id' => 'numeric|exists:insurances,id',
        'plan' => 'nullable|string|max:120',
        'number' => 'nullable|string|max:120'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'insurance_name'
    ];

    public function patient(){
        return $this->belongsTo('App\Models\Patient');
    }

    public function insurance(){
        return $this->belongsTo('App\Models\Insurance');
    }

    public function getInsuranceNameAttribute(){
        return $this->insurance->name;
    }
}