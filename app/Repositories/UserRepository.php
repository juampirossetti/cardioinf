<?php

namespace App\Repositories;

use App\Models\User;
use InfyOm\Generator\Common\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'email',
        'password',
        'remember_token'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return User::class;
    }

    public function create(array $attributes){

        if(isset($attributes['api_token'])){
            $attributes['api_token'] = str_random(60);
        }

        return parent::create($attributes);
    }

    public function updateCredentials($attributes, $id){
        $user = User::find($id);

        \DB::beginTransaction();
        try {
            $user->email = $attributes['email'];
            $user->password = bcrypt($attributes['password']);

            $user->save();
        } catch(Exception $e) {
            \DB::rollBack();
            throw $e;
        }
        \DB::commit();


        return $user;
    }

    public function select2Search($params){
        
        $users = \DB::table('users')->leftJoin('patients','users.patient_id','=','patients.id')
                        ->whereNotNull('users.patient_id')
                        ->where('users.patient_id', '!=','')
                        ->where('users.email','LIKE','%'.$params.'%')
                        ->orWhere('patients.name','LIKE','%'.$params.'%')
                        ->orWhere('patients.surname','LIKE','%'.$params.'%')
                        ->select(['users.email', 'users.id','patients.name','patients.surname'])->get();
        // $users = User::whereNotNull('patient_id')->get();
        
        return $users;
    }
}
