<!-- Day Field -->
<div class="form-group col-sm-6">
    {!! Form::label('day', 'Día:') !!}
    {!! Form::select('day', 
        ['0' => 'Lunes', '1' => 'Martes', '2' => 'Miercoles', '3' => 'Jueves', '4' => 'Viernes', '5' => 'Sabado', '6' => 'Domingo'], 
        isset($timetable) ? $timetable->getDay() : 0,
        ['class' => 'form-control']) !!}
</div>

<!-- Turn Field -->
<div class="form-group col-sm-6">
    {!! Form::label('turn', 'Turno:') !!}
    {!! Form::select('turn', ['0' => 'Mañana', '1' => 'Tarde'],
        isset($timetable) ? $timetable->getTurn() : 0, 
        ['class' => 'form-control', 'id' => 'turnpicker']) !!}
</div>

<!-- From Field -->
<div class="form-group col-sm-6">
    {!! Form::label('from', 'Desde:') !!}
    {!! Form::text('from', 
        null, 
        ['class' => 'form-control read-only', 'id' => 'fromtimepicker', 'readonly' => 'readonly']) !!}
</div>

<!-- Until Field -->
<div class="form-group col-sm-6">
    {!! Form::label('until', 'Hasta:') !!}
    {!! Form::text('until', 
        null, 
        ['class' => 'form-control read-only', 'id' => 'untiltimepicker', 'readonly' => 'readonly']) !!}
</div>

<!-- Delta Field -->
<div class="form-group col-sm-6">
    {!! Form::label('delta', 'Minutos entre turnos:') !!}
    {!! Form::text('delta',
        null,
        ['class' => 'form-control read-only', 'id' => 'deltatimepicker', 'readonly' => 'readonly']) !!}
</div>

<!-- Professional Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('professional_id', 'Médico:') !!}
    {!! Form::select('professional_id', array('null' => 'Seleccionar') + $professionals, 
        isset($timetable) ? $timetable->getProfessionalId() : 0,
        ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('medical_studies', 'Consultas que realiza:') !!}
    {!! Form::select('medical_studies[]', array('null' => 'Ninguna') + $medicalStudies, 
        isset($timetable) ? $timetable->medicalStudies->pluck('id')->all() : 0,
        ['class' => 'form-control', 'multiple' => ""]) !!}
    <h5><span class="">Mantenga presionado Ctrl para selección múltiple</span></h5>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('timetables.index') !!}" class="btn btn-default">Cancelar</a>
</div>
