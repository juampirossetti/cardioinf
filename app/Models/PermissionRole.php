<?php

namespace App\Models;

use Eloquent as Model;

use App\Traits\KeyModel\CompositeKeyModel;
/**
 * Class PermissionRole
 * @package App\Models
 * @version July 28, 2017, 2:05 pm UTC
 */
class PermissionRole extends Model
{
    use CompositeKeyModel;

    public $table = 'permission_role';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $primaryKey = ['permission_id', 'role_id'];
    public $incrementing = false;

    public $fillable = [
        'permission_id',
        'role_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'permission_id' => 'integer',
        'role_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function permission()
    {
        return $this->belongsTo(\App\Models\Permission::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class);
    }
}
