<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use OwenIt\Auditing\Contracts\Auditable;
/**
 * Class HistoryDetail
 * @package App\Models
 * @version June 15, 2017, 3:04 pm UTC
 */
class HistoryDetail extends Model implements Auditable
{
    use SoftDeletes;

    use \OwenIt\Auditing\Auditable;

    public $table = 'history_details';

    protected $dates = ['deleted_at'];

    public $fillable = [
        'date',
        'description',
        'history_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        //'date' => 'datetime',
        'description' => 'string',
        'history_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'date_format:d-m-Y H:i|required',
        'description' => 'string|required',
        'history_id' => 'string|exists:histories,id|required'
    ];

    public function files(){
        return $this->hasMany('App\Models\DetailFile');
    }

    public function history(){
        return $this->belongsTo('App\Models\History');
    }
    
}
