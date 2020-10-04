<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-edit"></i><span>Usuarios</span></a>
</li>

<li class="{{ Request::is('roles*') ? 'active' : '' }}">
    <a href="{!! route('roles.index') !!}"><i class="fa fa-edit"></i><span>Roles</span></a>
</li>

<li class="{{ Request::is('roleUsers*') ? 'active' : '' }}">
    <a href="{!! route('roleUsers.index') !!}"><i class="fa fa-edit"></i><span>Roles en usuarios</span></a>
</li>

<li class="{{ Request::is('permissions*') ? 'active' : '' }}">
    <a href="{!! route('permissions.index') !!}"><i class="fa fa-edit"></i><span>Permisos</span></a>
</li>

<li class="{{ Request::is('permissionRoles*') ? 'active' : '' }}">
    <a href="{!! route('permissionRoles.index') !!}"><i class="fa fa-edit"></i><span>Permisos en roles</span></a>
</li>

<li class="{{ Request::is('appointments*') ? 'active' : '' }}">
    <a href="{!! route('appointments.index') !!}"><i class="fa fa-edit"></i><span>Turnos</span></a>
</li>