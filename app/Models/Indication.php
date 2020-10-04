<?php

namespace App\Models;

use App\Models\BaseModel as Model;

use Carbon\Carbon;
/**
 * Class Appointment
 * @package App\Models
 * @version May 24, 2017, 11:18 pm UTC
 */
class Indication extends Model
{
    public $table = 'indications';
    
    public $fillable = [
        'medical_study_id',
        'insurance_id',
        'message',
        'enabled_appointment',
    ];

    /*
     * Hidden attributes for json responses
     */
    public static $hiddenJson = [
        'updated_at',
        'created_at',
        ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'medical_study_id' => 'integer',
        'insurance_id' => 'integer',
        'message' => 'string',
        'enabled_appointment' => 'boolean'
    ];

    protected $appends = [
        'have_message',
        'enabled_appointment_text',
        'insurance_name',
        'medical_study_name'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'medical_study_id' => 'numeric|exists:medical_studies,id',
        'insurance_id' => 'numeric|nullable|exists:insurances,id|unique_with:indications,medical_study_id',
        'message' => 'nullable|string|max:1024',
        'enabled_appointment' => 'required|boolean'
    ];

    protected $nullable = [
        'insurance_id'
    ];

    public function medicalStudy(){
        return $this->belongsTo('App\Models\MedicalStudy');
    }

    public function insurance(){
        return $this->belongsTo('App\Models\Insurance');
    }

    public function getHaveMessageAttribute(){
        if($this->message != null){
            return 'Si';
        } else {
            return 'No';
        }
    }

    public function getEnabledAppointmentTextAttribute(){
        if($this->enabled_appointment){
            return 'Si';
        } else {
            return 'No';
        }
    }

    public function getInsuranceNameAttribute(){
        if($this->insurance_id != null){
            return $this->insurance->name;
        } else {
            return 'Todas';
        }
    }

    public function getMedicalStudyNameAttribute(){
        return $this->medicalStudy->name;
    }

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            self::setNullables($model);
        });
    } 
}