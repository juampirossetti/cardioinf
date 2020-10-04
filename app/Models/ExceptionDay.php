<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;
/**
 * Class MedicalStudy
 * @package App\Models
 * @version August 7, 2017, 5:34 pm UTC
 */
class ExceptionDay extends Model
{

    public $table = 'exceptions_days';

    public $timestamps = false;
    
    public $fillable = [
        'date',
        'professional_id',
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
        'professional_name',
        'display_date',
        'display_ms'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'date_format:Y-m-d|required',
        'professional_id' => 'numeric|exists:professionals,id|unique_with:exceptions_days,date'
    ];

    public function medicalStudies() {
        return $this->belongsToMany('App\Models\MedicalStudy', 'exceptions_ms', 'exception_day_id', 'medical_study_id');
    }

    public function professional(){
        return $this->belongsTo('App\Models\Professional');
    }
    
    public function getProfessionalNameAttribute(){
        return $this->professional->getCompleteName();
    }

    public function getDisplayDateAttribute(){
        
        $date = Carbon::createFromFormat('Y-m-d',$this->date)->format('d-m-Y');
        
        return $date;
    }

    public function getDisplayMsAttribute(){
        $ms = $this->medicalStudies;
        
        $result = array();
        
        foreach($ms as $m){
            $result[] = $m->name;
        }

        return implode(', ',$result);
    }
}
