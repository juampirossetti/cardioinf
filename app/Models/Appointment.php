<?php

namespace App\Models;

use App\Models\BaseModel as Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\ViewFormatter as Format;

use App\Models\Professional;

use App\Models\Patient;

use Carbon\Carbon;
/**
 * Class Appointment
 * @package App\Models
 * @version May 24, 2017, 11:18 pm UTC
 */
class Appointment extends Model
{
    //use SoftDeletes;

    public $table = 'appointments';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'date',
        'time',
        'money',
        'coupons',
        'insurance_id',
        'medical_study_id',
        'status',
        'comment',
        'professional_id',
        'patient_id',
        'patient_dni',
        'patient_name',
        'patient_surname',
        'patient_address',
        'patient_primary_phone',
        'patient_secondary_phone',
        'patient_plan',
        'patient_affiliate_number',
        'patient_professional',
        'patient_email',
        'order_number',
        'owner',
        'user_id'
    ];

    /*
     * Hidden attributes for json responses
     */
    public static $hiddenJson = [
        // 'patient_id',
        // 'money',
        // 'coupons',
        // 'insurance_id',
        // 'date',
        // 'time',
        'updated_at',
        'created_at',
        'deleted_at'
        ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'start',
        'end',
        'prof_id',
        'professional_name',
        'pati_id',
        'status_id',
        'title',
        'medical_study_name',
        'insurance_name',
        'isReserved',
        'ownername'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'money' => 'float',
        'coupons' => 'integer',
        'insurance_id' => 'integer',
        'status' => 'integer',
        'professional_id' => 'integer',
        'patient_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'date_format:Y-m-d|required',
        'time' => 'required|date_format:H:i',
        'money' => 'numeric|nullable',
        'coupons' => 'numeric|min:0|max:10|nullable',
        'insurance_id' => 'nullable|numeric|exists:insurances,id',
        'status' => 'numeric|min:0|max:3|required',
        'professional_id' => 'numeric|exists:professionals,id',
        'patient_id' => 'nullable|numeric|exists:patients,id',
        'medical_study_id' => 'sometimes|nullable|exists:medical_studies,id',
        'comment' => 'string|nullable',
        
        /* Patient information */
        'patient_name' => 'string|nullable',
        'patient_dni' => 'string|nullable',
        'patient_surname' => 'string|nullable',
        'patient_address' => 'string|nullable',
        'patient_primary_phone' => 'string|nullable',
        'patient_secondary_phone' => 'string|nullable',
        'patient_plan' => 'string|nullable',
        'patient_affiliate_number' => 'string|nullable',
        'patient_professional' => 'string|nullable',
        'patient_email' => 'string|nullable'
        
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rulesForPatient = [
        'date' => 'date_format:Y-m-d|required',
        'time' => 'required|date_format:H:i',
        'insurance_id' => 'nullable|numeric|exists:insurances,id',
        'professional_id' => 'numeric|exists:professionals,id',
        'patient_id' => 'nullable|numeric|exists:patients,id',
        'medical_study_id' => 'nullable|numeric|exists:medical_studies,id'
    ];

    /**
     * Nullable fields
     *
     * @var array
     */
    protected $nullable = [
        'money',
        'coupons',
        'insurance_id',
        'medical_study_id',
        'patient_id',
        'medical_study_id',
        'comment',
        'patient_dni',
        'patient_name',
        'patient_surname',
        'patient_address',
        'patient_primary_phone',
        'patient_secondary_phone',
        'patient_plan',
        'patient_affiliate_number',
        'patient_professional',
        'patient_email'
    ];

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        /*
         * Set empty attributes to null before save
         */
        static::saving(function ($model) {
            self::setNullables($model);
        });
    }

    /*
     * Relationships
     */

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function professional() {
        return $this->belongsTo('App\Models\Professional');
    }

    public function medicalStudy() {
        return $this->belongsTo('App\Models\MedicalStudy');
    }

    public function reservation(){
        return $this->hasOne('App\Models\TempReservation');
    }

    public function insurance(){
        return $this->belongsTo('App\Models\Insurance');
    }
    /*
     * Reset fields
     */
    public function reset() {
        $this->money = null;
        $this->coupons = null;
        $this->insurance_id = null;
        $this->medical_study_id = null;
        $this->patient_id = null;
        $this->status = 0;

        $this->save();
    }
    /*
     * Start Date for the calendar view
     */
    public function getStartAttribute() {
        return $this->attributes['date'].' '.$this->attributes['time'];
    }

    /*
     * End Date for the calendar view
     */ 
    public function getEndAttribute() {
        $datetime = $this->attributes['date'].' '.$this->attributes['time'];
        
        $end = Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->addMinutes('10')->toDateTimeString();

        return $end;
    }

    public function getOwnernameAttribute(){
        if($this->owner == "me"){
            return $this->getPatientName();
        } else {
            return $this->patient_name.' '.$this->patient_surname;
        }
    }
    /*
     * Patient Id for the calendar view
     */
    public function getPatiIdAttribute() {
        return $this->attributes['patient_id'];
    }

    /*
     * Professional Id for the calendar view
     */
    public function getProfIdAttribute() {
        return $this->attributes['professional_id'];
    }

    /*
     * Status Id for the calendar view
     */
    public function getStatusIdAttribute() {
        return $this->attributes['status'];
    }

    public function getTitleAttribute() {
        //return $this->patient;
        if($this->patient != null || $this->patient_surname != null || $this->patient_name != null) {
            $o = '';
            if($this->order_number != null) {
                $o .='('.$this->order_number.') - ';
            }
            if($this->patient != null && $this->owner == 'me'){
                $o .= $this->patient->getCompleteName();
            } else {
                $o .= $this->patient_surname.' '.$this->patient_name;
            }
            
            if($this->medical_study_id != null) {
                $o .=' - '.$this->medicalStudy->acronym;
            }

            if($this->insurance_id != null) {
                $o .=' - '.$this->insurance->short_name;   
            }

            if($this->comment != null) {
                $o .=' - '.$this->comment;
            }
            return $o;
        } else {
            if($this->is_reserved){
                return 'Reservado';
            } else {
                return $this->status;
            }
        }
        //return 'Nombre Paciente (Obra Social)';
    }
    public function getTimeAttribute() {
        return Format::createTimeHi($this->attributes['time']);
    }

    public function getMedicalStudyNameAttribute() {
        $medicalStudy = MedicalStudy::find($this->attributes['medical_study_id']);
        return $medicalStudy == null ? 'No Asignado' : $medicalStudy->name;
    }

    public function getInsuranceNameAttribute() {
        $insurance = Insurance::find($this->attributes['insurance_id']);
        return $insurance == null ? 'No Asignada' : $insurance->name;
    }

    public function getIsReservedAttribute($value) {
        if($this->reservation != null){
            return true;
        } else {
            return false;
        }
    }

    public function getProfessionalNameAttribute() {
        $professional = Professional::findOrFail($this->attributes['professional_id']);
        return $professional->getCompleteName();
    }

    public function getProfessionalId() {
        return $this->attributes['professional_id'];
    }

    public function getPatientId() {
        return $this->attributes['patient_id'];
    }

    public function getPatientNameAttribute($value){
        if($this->attributes['patient_id'] != null && $this->attributes['owner'] == "me"){
            $patient = Patient::findOrFail($this->attributes['patient_id']);
            return $patient->name;
        } else {
            return $value;
        }
    }

    public function getPatientSurnameAttribute($value){
        if($this->attributes['patient_id'] != null && $this->attributes['owner'] == "me"){
            $patient = Patient::findOrFail($this->attributes['patient_id']);
            return $patient->surname;
        } else {
            return $value;
        }
    }
    /**
     * Mutators and methods for blade
     *
     */
    public static $status = [
        '0' => 'Libre', 
        '1' => 'Ocupado', 
        '2' => 'Sala de espera', 
        '3' => 'Finalizado',
        '4' => 'Cancelado'
    ];

    public function getStatusAttribute($value) {
        return self::$status[$value];
    }

    public function getStatus() {
        $this->attributes['status'];
    }

    public function setPatientIdAttribute($patient_id){

        $this->attributes['patient_id'] = ($patient_id != "") ? $patient_id : null;

    }

    public function getEmail(){
        if($this->patient != null && $this->patient->user != null){
            return $this->patient->user->email;
        } else {
            if ( $this->user != null ){
                return $this->user->email;
            } else {
                return $this->patient_email;
            }
        }
    }

    public function getPatientName(){
        if($this->patient != null){
            return $this->patient->getCompleteName();
        } else {
            return $this->patient_name.' '.$this->patient_surname;
        }
    }

    public function getNameForEmail(){
        if($this->owner == 'other'){
            return $this->patient_name.' '.$this->patient_surname;
        } else {
            return $this->patient->getCompleteName();
        }   
    }
}
