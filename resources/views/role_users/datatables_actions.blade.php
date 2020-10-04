{!! Form::open(['route' => ['roleUsers.destroy', $user_id], 'method' => 'delete']) !!}
<div class='btn-group'>
    {!! Form::hidden('role_id', $role_id) !!}
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('¿Esta seguro que desea eliminar este registro?')"
    ]) !!}
</div>
{!! Form::close() !!}
