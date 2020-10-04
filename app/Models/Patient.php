<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Patient
 * @package App\Models
 * @version May 23, 2017, 10:28 pm UTC
 */
class Patient extends Model
{

    public $table = 'patients';

    public $fillable = [
        'name',
        'surname',
        'dni',
        'address',
        'primary_phone',
        'secondary_phone',
        'insurance_id',
        'professional',
        'plan',
        'affiliate_number',
        'email'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'surname' => 'string',
        'dni' => 'string',
        'address' => 'string',
        'primary_phone' => 'string',
        'secondary_phone' => 'string',
        'insurance_id' => 'integer',
        'professional' => 'string',
        'plan' => 'string',
        'affiliate_number' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|max:60|required',
        'surname' => 'required',
        'dni' => 'required|digits_between:1,15|numeric|unique:patients,dni',
        'address' => 'string|nullable',
        'primary_phone' => 'string|nullable',
        'secondary_phone' => 'string|nullable',
        'insurance_id' => 'nullable|integer|exists:insurances,id',
        'professional' => 'nullable|string',
        'plan' => 'string|nullable',
        'affiliate_number' => 'string|nullable'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'insurance_name',
        //'email'
    ];
    /*
     * Relationships
     */

    public function insurance(){
        return $this->belongsTo('App\Models\Insurance');
    }

    public function insurances() {
        return $this->belongsToMany('App\Models\Insurance','patients_insurances', 'patient_id','insurance_id');
    }

    // public function professional(){
    //     return $this->belongsTo('App\Models\Professional');
    // }

    public function histories() {
        return $this->hasMany('App\Models\History');
    }

    public function cards() {
        return $this->hasMany('App\Models\Card');
    }

    public function appointments() {
        return $this->hasMany('App\Models\Appointment');
    }

    public function user() {
        return $this->hasOne('App\Models\User');
    }
    /**
     * Nullable fields
     *
     * @var array
     */
    protected $nullable = [
        'address',
        'primary_phone',
        'secondary_phone',
        'insurance_id',
        'professional',
        'plan'
    ];

    /**
     * Listen for save event
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            self::setNullables($model);
        });

        static::deleting(function ($model) {
            foreach($model->appointments as $appointment) {
                $appointment->reset();
            }
        });
    }

    public function setInsuranceIdAttribute($insurance_id){

        $this->attributes['insurance_id'] = ($insurance_id != "") ? $insurance_id : null;
    }

    public function getCompleteName() {
        return $this->name.' '.$this->surname;
    }

    public function getInsuranceId(){
        return $this->insurance_id;
    }

    // public function getProfessionalId(){
    //     return $this->professional_id;
    // }

    public function getInsuranceNameAttribute(){
        return $this->getInsurance();
    }

    public function getInsurance(){
        if ($this->insurance_id == null) {
            return 'No asignado';
        } else {
            return $this->insurance->getName();
        }
    }

    public function getEmailAttribute(){
        if ($this->user == null) {
            return $this->attributes['email'];
        } else {
            return $this->user->email;
        }
    }

    public function detachInsurance(){
        $this->insurance_id = null;
    }

    public function jsonResponse(){
        return [
            'insurance' => ($this->attributes['insurance_id'] != null) ? $this->insurance->name : null,
            'name' => $this->name,
            'surname' => $this->surname,
            'id' => $this->id,
            'dni' => $this->dni,
            'insurance_id' => $this->insurance_id,
            'professional' => $this->professional,
            'address' => $this->address,
            'primary_phone' => $this->primary_phone,
            'secondary_phone' => $this->secondary_phone,
            'plan' => $this->plan,
            'affiliate_number' => $this->affiliate_number,
            'email' => $this->email
        ];
    }
    
}
