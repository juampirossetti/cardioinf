<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Insurance
 * @package App\Models
 * @version May 23, 2017, 9:43 pm UTC
 */
class Insurance extends Model
{
    public $table = 'insurances';

    public $fillable = [
        'name',
        'enabled',
        'patient_enabled',
        'short_name',
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
        'short_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|max:60|required|unique:insurances,name',
        'description' => 'string|nullable',
        'patient_enabled' => 'numeric',
        'enabled' => 'numeric',
        'short_name' => 'string|max:60|required'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_patient_enabled'
    ];
    /*
     * Relationships
     */
    public function patients(){
        return $this->hasMany('App\Models\Patient');
    }
    /**
     * Nullable fields
     *
     * @var array
     */
    protected $nullable = [
        'description'
    ];

    public function getEnabledAttribute($value) {
        return ($value == 0 ? 'No' : 'Si');
    }

    public function isEnabled(){
        //dd($this->enabled);
        return $this->attributes['enabled'];
    }

    public function isPatientEnabled(){
        return $this->attributes['patient_enabled'];
    }

    public function getName(){
        return $this->name;
    }

    public function getIsPatientEnabledAttribute(){
        return ($this->attributes['patient_enabled'] == true) ? 'Si' : 'No';
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
