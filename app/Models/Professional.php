<?php

namespace App\Models;

use App\Models\BaseModel as Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Timetable;

/**
 * Class Professional
 * @package App\Models
 * @version May 23, 2017, 9:33 pm UTC
 */
class Professional extends Model
{
    public $table = 'professionals';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'name',
        'surname',
        'speciality',
        'internal_id',
        'enabled',
        'patient_enabled'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'surname' => 'string',
        'speciality' => 'string',
        'internal_id' => 'string'
    ];

    protected $appends = [
        'complete_name',
        'is_patient_enabled'
    ];
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'string|max:60|required',
        'surname' => 'string|max:60|required',
        'internal_id' => 'string|numeric|nullable'
    ];

    /*
     * Relationships
     */

    public function timetables() {
        return $this->hasMany('App\Models\Timetable');
    }

    public function exceptionsDays() {
        return $this->hasMany('App\Models\ExceptionDay');
    }

    public function medicalStudies() {
        return $this->belongsToMany('App\Models\MedicalStudy','professional_study', 'professional_id','medical_study_id');
    }

    public function insurances() {
        return $this->belongsToMany('App\Models\Insurance','professional_insurance', 'professional_id','insurance_id');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    /**
     * Nullable fields
     *
     * @var array
     */
    protected $nullable = [];

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

    public function getCompleteName() {
        return $this->name.' '.$this->surname;
    }

    public function getCompleteNameAttribute($value) {
        return $this->getCompleteName();
    }

    public function getIsPatientEnabledAttribute(){
        return ($this->attributes['patient_enabled'] == true) ? 'Si' : 'No';
    }

    public function isEnabled(){
        return $this->attributes['enabled'];
    }

    public function isPatientEnabled(){
        return $this->attributes['patient_enabled'];
    }

    public function does($medical_study_id, $date, $time = null) {
        // datos de entrada
        $day_of_week = date('N', strtotime($date)) - 1;
        if($time != null)
            $strtime = strtotime($time);

        //si existe excepcion: lo hace o no lo hace por la excepcion
        $exceptionDay = $this->exceptionsDays()->where('date', $date)->first();
        if(!empty($exceptionDay))
        {
            foreach($exceptionDay->medicalStudies as $m){
                if ($m->id == $medical_study_id){
                    return true;
                }
            }
            //habia excepcion y no incluia ese estudio
            return false;
        }

        $does = Timetable::whereHas('medicalStudies', function($q) use ($medical_study_id) {
            $q->where('medical_studies.id', $medical_study_id);
        })->where('day',$day_of_week)
          ->where('professional_id', $this->id);

        if($time != null){
            $does = $does->where('from','<=',$time)
                         ->where('until', '>=', $time);
        }

        $does = $does->exists();

        return $does;
    }

    public function worksOn($date){
        $day_of_week = date('N', strtotime($date)) - 1;
        //chequeo en cada timetable si el profesional hace consultas.
        foreach ($this->timetables as $timetable){
            if($timetable->getDay() == $day_of_week){
                return true;
            }
        }

        return false;
    }
    
}
