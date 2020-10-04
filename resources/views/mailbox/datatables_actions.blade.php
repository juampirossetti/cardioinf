{!! Form::open(['route' => ['mailbox.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('mailbox.show', $id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('¿Esta seguro que desea eliminar este registro?')"
    ]) !!}
</div>
{!! Form::close() !!}