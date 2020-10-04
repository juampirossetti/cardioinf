<?php

namespace App\Repositories;

use App\Models\RoleUser;
use InfyOm\Generator\Common\BaseRepository;

use App\Traits\Repository\DeleteByModel;

class RoleUserRepository extends BaseRepository
{
    use DeleteByModel;
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'role_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return RoleUser::class;
    }

    public function findByUserIdAndRoleId($user_id, $role_id) {
        
        return RoleUser::where('user_id',$user_id)->where('role_id', $role_id)->first();
    }
}
