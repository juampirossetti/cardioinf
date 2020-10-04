{!! Form::open(['route' => ['histories.destroy', $history->id], 'method' => 'delete']) !!}
<div class='btn-group'>
    <a href="{{ route('histories.show', $history->id) }}" class='btn btn-default btn-xs'>
        <i class="glyphicon glyphicon-eye-open"></i>
    </a>
    {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => "return confirm('¿Esta usted seguro?')"
    ]) !!}
</div>
{!! Form::close() !!}