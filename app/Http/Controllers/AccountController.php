<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use App\Repositories\UserRepository;

use App\Http\Controllers\AppBaseController;
use Response;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use App\Http\Requests\UpdateAccountRequest;
use Auth;
use Flash;

class AccountController extends AppBaseController
{
    
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display the specified User.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show()
    {
        $id = Auth::user()->id;

        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(url('/'));
        }

        return view('account.show')->with('user', $user);
    }

    public function update(UpdateAccountRequest $request) {
        
        $user = Auth::user();

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(url('/'));
        }

        $user = $this->userRepository->updateCredentials($request->only('email','password'), $user->id);

        Flash::success('Los datos de su cuenta fueron actualizados correctamente');

        return redirect(route('account.show'));
    }
}