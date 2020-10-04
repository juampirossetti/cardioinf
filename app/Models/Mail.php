<?php

namespace App\Models;

use App\Models\BaseModel as Model;

/**
 * Class Mail
 * @package App\Models
 * @version May 23, 2017, 9:33 pm UTC
 */
class Mail extends Model
{
    public $table = 'emails';
    
    public $timestamps = false;

    public $fillable = [
        'to',
        'subject',
        'sended_date',
        'content',
        'user_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'to' => 'string',
        'subject' => 'string',
        //'sended_date' => 'datetime',
        'content' => 'string',
        'user_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'to' => 'string|email|required',
        'subject' => 'string|max:256|required',
        'content' => 'string|required',
    ];

    /*
     * Relationships
     */

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}