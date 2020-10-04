<!-- Professional Id Field -->
<div class="form-group">
    {!! Form::label('professional_id', 'Médico:') !!}
    <p>{!! $timetable->professional_id !!}</p>
</div>

<!-- Day Field -->
<div class="form-group">
    {!! Form::label('day', 'Día:') !!}
    <p>{!! $timetable->day !!}</p>
</div>

<!-- Turn Field -->
<div class="form-group">
    {!! Form::label('turn', 'Turno:') !!}
    <p>{!! $timetable->turn !!}</p>
</div>

<!-- From Field -->
<div class="form-group">
    {!! Form::label('from', 'Desde:') !!}
    <p>{!! $timetable->from !!}</p>
</div>

<!-- Until Field -->
<div class="form-group">
    {!! Form::label('until', 'Hasta:') !!}
    <p>{!! $timetable->until !!}</p>
</div>

<!-- Delta Field -->
<div class="form-group">
    {!! Form::label('delta', 'Minutos entre turnos:') !!}
    <p>{!! $timetable->delta !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('medical_studies', 'Consultas que se realizan:') !!}
    <ul>
    @foreach($timetable->medicalStudies as $ms)
        <li>{!! $ms->name !!}</li>
    @endforeach
    </ul>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creado el:') !!}
    <p>{!! $timetable->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Última actualización:') !!}
    <p>{!! $timetable->updated_at !!}</p>
</div>

