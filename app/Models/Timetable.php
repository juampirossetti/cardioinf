<?php

namespace App\Models;

use App\Models\BaseModel as Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Formatter\TimetableView;

// use App\Helpers\ViewFormatter as Format;

// use App\Models\Professional;
/**
 * Class Timetable
 * @package App\Models
 * @version May 23, 2017, 11:09 pm UTC
 */
class Timetable extends Model
{
    use TimetableView;
    
    public $table = 'timetables';
    
    protected $dates = ['deleted_at'];

    public $fillable = [
        'day',
        'turn',
        'from',
        'until',
        'delta',
        'professional_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'day' => 'integer',
        'turn' => 'integer',
        'professional_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'day' => 'numeric|min:0|max:7|required',
        'turn' => 'numeric|min:0|max:1|required',
        'from' => 'required|date_format:H:i',
        'until' => 'required|date_format:H:i',
        'delta' => 'required|date_format:H:i',
        'professional_id' => 'numeric|exists:professionals,id'
    ];

    /*
     * Relationships
     */

    public function professional() {
        return $this->belongsTo('App\Models\Professional');
    }

    public function medicalStudies() {
        return $this->belongsToMany('App\Models\MedicalStudy', 'study_timetable', 'timetable_id', 'medical_study_id');
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
}
