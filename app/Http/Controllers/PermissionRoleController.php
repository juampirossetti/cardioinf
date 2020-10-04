<?php

namespace App\Http\Controllers;

use App\DataTables\PermissionRoleDataTable;
//use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePermissionRoleRequest;
use App\Http\Requests\UpdatePermissionRoleRequest;
use App\Repositories\PermissionRoleRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class PermissionRoleController extends AppBaseController
{
    /** @var  PermissionRoleRepository */
    private $permissionRoleRepository;

    public function __construct(PermissionRoleRepository $permissionRoleRepo)
    {
        $this->permissionRoleRepository = $permissionRoleRepo;
    }

    /**
     * Display a listing of the PermissionRole.
     *
     * @param PermissionRoleDataTable $permissionRoleDataTable
     * @return Response
     */
    public function index(PermissionRoleDataTable $permissionRoleDataTable)
    {
        return $permissionRoleDataTable->render('permission_roles.index');
    }

    /**
     * Show the form for creating a new PermissionRole.
     *
     * @return Response
     */
    public function create()
    {
        return view('permission_roles.create');
    }

    /**
     * Store a newly created PermissionRole in storage.
     *
     * @param CreatePermissionRoleRequest $request
     *
     * @return Response
     */
    public function store(CreatePermissionRoleRequest $request)
    {
        $input = $request->all();

        $permissionRole = $this->permissionRoleRepository->create($input);

        Flash::success('Permiso asociado a rol correctamente');

        return redirect(route('permissionRoles.index'));
    }

    /**
     * Remove the specified PermissionRole from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        $role_id = $id;

        $permissionRole = $this->permissionRoleRepository->findByRoleIdAndPermissionId($role_id, $request->get('permission_id'));

        if (empty($permissionRole)) {
            Flash::error('Permiso asociado a rol no encontrado');

            return redirect(route('permissionRoles.index'));
        }

        $this->permissionRoleRepository->deleteByModel($permissionRole);

        Flash::success('Permiso asociado a rol eliminado correctamente');

        return redirect(route('permissionRoles.index'));
    }
}
