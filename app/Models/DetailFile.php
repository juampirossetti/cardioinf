<?php

namespace App\Models;

use App\Models\BaseModel as Model;

/**
 * Class DetailFile
 * @package App\Models
 * @version May 23, 2017, 9:33 pm UTC
 */
class DetailFile extends Model
{
    public $table = 'detail_files';
    
    public $timestamps = false;

    public $fillable = [
        'path',
        'name',
        'history_detail_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'path' => 'string',
        'name' => 'string',
        'history_detail_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'path' => 'string|required',
        'name' => 'string|nullable',
        'history_detail_id' => 'numeric|exists:history_details,id|nullable'
    ];

    public function historyDetail(){
        return $this->belongsTo('App\Models\HistoryDetail', 'history_detail_id');
    }
}