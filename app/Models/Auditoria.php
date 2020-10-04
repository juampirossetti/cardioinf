<?php

namespace App\Models;

use App\Models\BaseModel as Model;

/**
 * Class Mail
 * @package App\Models
 * @version May 23, 2017, 9:33 pm UTC
 */
class Auditoria extends Model
{
    public $table = 'auditoria';
    
    public $timestamps = false;

    public $fillable = [
        'date',
        'category',
        'content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'category' => 'string',
        'content' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'date' => 'date|required',
        'category' => 'string|max:256|required',
        'content' => 'string|required',
    ];
}