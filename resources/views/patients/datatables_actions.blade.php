{!! Form::open(['route' => ['patients.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('patients.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    @role('secretary')
    <a href="{{ route('patients.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-edit"></i>
    </a>
    @if($email != null)
    <a href="{{ route('mailbox.create', ['email' => $email]) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-envelope"></i>
    </a>
    @endif
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('¿Esta seguro que desea eliminar este registro?')"
    ]) !!}
    @endrole
</div>
{!! Form::close() !!}
