<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;


/**
 * Class History
 * @package App\Models
 * @version May 25, 2017, 12:06 am UTC
 */
class History extends Model implements Auditable
{
    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    public $table = 'histories';
    

    protected $dates = ['deleted_at'];


    public $fillable = [
        'professional_id',
        'patient_name',
        'patient_surname',
        'patient_os',
        'patient_os_number',
        'comments',
        'ultima_visita',
        'domicilio',
        'edad',
        'telefono',
        'medico_cabecera',
        'dni',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'professional_id' => 'integer',
        'patient_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'professional_id' => 'numeric|exists:professionals,id',
        'patient_name' => 'string|max:60|required',
        'patient_surname' => 'string|max:60|required',
        'patient_os' => 'nullable|exists:insurances,id',
        'patient_os_number' =>'nullable|string|max:60',
        'comments' => 'nullable|string|max:2048',
        'user_id' => 'nullable|exists:users,id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'insurance_name',
        'user_completename',
    ];

    /*
     * Relationships
     */

    public function professional() {
        return $this->belongsTo('App\Models\Professional');
    }

    public function patient() {
        return $this->belongsTo('App\Models\Patient');
    }

    public function os(){
        return $this->belongsTo('App\Models\Insurance','patient_os');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id');
    }

    public function details(){
        return $this->hasMany('App\Models\HistoryDetail')->orderBy('date', 'desc');;
    }

    public function getInsuranceNameAttribute(){
        if ($this->patient_os != null) {
            return $this->os->getName();
        }
    }

    public function getUserCompletenameAttribute(){
        if ($this->user_id != null) {
            if(count($this->user->patient)){
                return $this->user->patient->getCompleteName();
            }
        }
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
