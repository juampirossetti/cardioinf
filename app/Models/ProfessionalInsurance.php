<?php

namespace App\Models;

use App\Models\BaseModel as Model;

use Carbon\Carbon;
/**
 * Class Appointment
 * @package App\Models
 * @version May 24, 2017, 11:18 pm UTC
 */
class ProfessionalInsurance extends Model
{
    public $table = 'professional_insurance';
    
    public $fillable = [
        'professional_id',
        'insurance_id',
        'message',
        'enabled_patient',
        'enabled_appointment',
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
        'professional_id' => 'integer',
        'insurance_id' => 'integer',
        'message' => 'string',
        'enabled_patient' => 'boolean',
        'enabled_appointment' => 'boolean'
    ];

    protected $appends = [
        'have_message',
        'enabled_patient_text',
        'enabled_appointment_text',
        'insurance_name'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'professional_id' => 'numeric|exists:professionals,id',
        'insurance_id' => 'numeric|exists:insurances,id',
        'message' => 'nullable|string|max:120',
        'enabled_patient' => 'required|boolean',
        'enabled_appointment' => 'required|boolean'
    ];

    public function professional(){
        return $this->belongsTo('App\Models\Professional');
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

    public function getEnabledPatientTextAttribute(){
        if($this->enabled_patient){
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
        return $this->insurance->name;
    }
}