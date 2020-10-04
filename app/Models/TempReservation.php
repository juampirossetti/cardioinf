<?php

namespace App\Models;

use App\Models\BaseModel as Model;

use Carbon\Carbon;
/**
 * Class Appointment
 * @package App\Models
 * @version May 24, 2017, 11:18 pm UTC
 */
class TempReservation extends Model
{
    public $table = 'temp_reservations';
    
    public $fillable = [
        'patient_id',
        'appointment_id',
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
        'appointment_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'patient_id' => 'numeric|exists:patients,id|unique:temp_reservations,patient_id',
        'appointment_id' => 'numeric|exists:appointments,id|unique:temp_reservations,appointment_id'
    ];

    public function appointment(){
        return $this->belongsTo('App\Models\Appointment');
    }
}