<?php

namespace App\Http\Controllers\API;

use App\Http\Requests;

use Illuminate\Http\Request;

use App\Http\Controllers\AppBaseController;

use App\Http\Requests\API\CreatePasswordRequest;

use App\Http\Requests\API\CreateProfessionalPasswordRequest;

use App\Repositories\UserRepository;

use App\Models\Patient;

use App\Models\Professional;

use App\Models\Role;

use Response;


class ApiUserController extends AppBaseController {

    private $userRepository;
    
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }
    
    public function generatePassword(CreatePasswordRequest $request) {

        $input = $request->all();
        
        $input['password'] = rand(100000,999999);
        
        $user = Patient::find($input['patient_id'])->user;
        
        if ($user == null) {
            $user = $this->userRepository->create($input);
        } else {
            $user = $this->userRepository->updateCredentials($input, $user->id);
        }

        return response()->json([
            'status' => 'El recurso se actualizó correctamente',
            'password' => $input['password']
        ], 201);
    }

    public function generateProfessionalPassword(CreateProfessionalPasswordRequest $request) {

        $input = $request->all();

        $password = rand(100000,999999);
        
        $input['password'] = $password;
        
        $professional = Professional::find($input['professional_id']);
        
        $user_type = 'professional';
        
        if ($professional->user == null) {
            $input['password'] = bcrypt($password);
            $user = $this->userRepository->create($input);
            
            $role = Role::where('name',$user_type)->first();
            $user->attachRole($role);
            
            $professional->user_id = $user->id;
            $professional->save(); 

        } else {
            $user = $this->userRepository->updateCredentials($input, $professional->user->id);
        }

        return response()->json([
            'status' => 'El recurso se actualizó correctamente',
            'password' => $password
        ], 201);

    }

    public function patients(Request $request) {
        
        $searchParams = null;
        if($request->has('search')){
            $searchParams = $request->get('search');
        }

        $users = [];
        if($searchParams != null){
            $users = $this->userRepository->select2Search($searchParams);
        }

        return response()->json([
            'users' => $users
        ], 201);        
    }
};