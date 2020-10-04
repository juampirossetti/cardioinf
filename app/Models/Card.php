<?php

namespace App\Models;

use App\Models\BaseModel as Model;

/**
 * Class PatientInsurance
 * @package App\Models
 * @version May 24, 2017, 11:18 pm UTC
 */
class Card extends Model
{
    public $table = 'cards';
    
    public $fillable = [
        'patient_id',
        'professional_id',
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
        'professional_id' => 'integer',
        'number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_id' => 'numeric|exists:patients,id',
        'professional_id' => 'numeric|exists:professionals,id',
        'number' => 'nullable|string|max:120'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'professional_name'
    ];

    public function patient(){
        return $this->belongsTo('App\Models\Patient');
    }

    public function professional(){
        return $this->belongsTo('App\Models\Professional');
    }

    public function getProfessionalNameAttribute(){
        return $this->professional->getCompleteName();
    }
}