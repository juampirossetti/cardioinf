{!! Form::open(['route' => ['permissionRoles.destroy', $role_id], 'method' => 'delete']) !!}
<div class='btn-group'>
    {!! Form::hidden('permission_id', $permission_id) !!}
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('¿Esta seguro que desea eliminar este registro?')"
    ]) !!}
</div>
{!! Form::close() !!}
