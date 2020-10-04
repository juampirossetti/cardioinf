<?php

namespace App\Models;

use Eloquent as Model;

use App\Traits\KeyModel\CompositeKeyModel;
/**
 * Class RoleUser
 * @package App\Models
 * @version July 27, 2017, 5:46 pm UTC
 */
class RoleUser extends Model
{
    use CompositeKeyModel;

    public $table = 'role_user';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $primaryKey = ['user_id', 'role_id'];
    public $incrementing = false;

    public $fillable = [
        'user_id',
        'role_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'role_id' => 'integer'
    ];

    protected $appends = [
        'user_name',
        'role_name',
        'email'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function getUserNameAttribute()
    {
        return $this->user->name;  
    }

    public function getRoleNameAttribute()
    {
        return $this->role->name;  
    }

    public function getEmailAttribute()
    {
        return $this->user->email;  
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
