<?php

namespace App\Repositories;

use App\Models\PermissionRole;
use InfyOm\Generator\Common\BaseRepository;

use App\Traits\Repository\DeleteByModel;

class PermissionRoleRepository extends BaseRepository
{
    use DeleteByModel;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'role_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PermissionRole::class;
    }

    public function findByRoleIdAndPermissionId($role_id, $permission_id) {
        return PermissionRole::where('role_id',$role_id)->where('permission_id', $permission_id)->first();
    }
}
