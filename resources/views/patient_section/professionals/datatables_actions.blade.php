{!! Form::open(['route' => 'patient.appointments.create', 'method' => 'GET']) !!}
{!! Form::hidden('professional_id', $id) !!}
<div class='btn-group'>
    <button type="submit" class="btn btn-primary btn-flat">Solicitar Turno</button>
</div>
{!! Form::close() !!}

