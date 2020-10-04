<?php

namespace App\Http\Controllers;

use App\DataTables\RoleUserDataTable;
//use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreateRoleUserRequest;
use App\Http\Requests\UpdateRoleUserRequest;
use App\Repositories\RoleUserRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class RoleUserController extends AppBaseController
{
    /** @var  RoleUserRepository */
    private $roleUserRepository;

    public function __construct(RoleUserRepository $roleUserRepo)
    {
        $this->roleUserRepository = $roleUserRepo;
    }

    /**
     * Display a listing of the RoleUser.
     *
     * @param RoleUserDataTable $roleUserDataTable
     * @return Response
     */
    public function index(RoleUserDataTable $roleUserDataTable)
    {
        return $roleUserDataTable->render('role_users.index');
    }

    /**
     * Show the form for creating a new RoleUser.
     *
     * @return Response
     */
    public function create()
    {
        return view('role_users.create');
    }

    /**
     * Store a newly created RoleUser in storage.
     *
     * @param CreateRoleUserRequest $request
     *
     * @return Response
     */
    public function store(CreateRoleUserRequest $request)
    {
        $input = $request->all();

        $roleUser = $this->roleUserRepository->create($input);

        Flash::success('Rol asignado a usuario correctamente');

        return redirect(route('roleUsers.index'));
    }

    /**
     * Remove the specified RoleUser from storage.
     *
     * @param  int $id = the user id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {   
        $user_id = $id;

        $roleUser = $this->roleUserRepository->findByUserIdAndRoleId($user_id, $request->get('role_id'));

        if (empty($roleUser)) {
            Flash::error('Rol asignado a usuario no encontrado');

            return redirect(route('roleUsers.index'));
        }
        
        $this->roleUserRepository->deleteByModel($roleUser);

        Flash::success('Rol asignado a usuario eliminado correctamente');

        return redirect(route('roleUsers.index'));
    }
}
