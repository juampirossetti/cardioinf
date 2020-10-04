<!-- Id Field -->
<!-- <div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $professional->id !!}</p>
</div> -->

<!-- Surname Field -->
<div class="form-group">
    {!! Form::label('surname', 'Apellido:') !!}
    <p>{!! $professional->surname !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{!! $professional->name !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('speciality', 'Especialidad:') !!}
    <p>{!! $professional->speciality !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('medical_studies', 'Consultas que realiza:') !!}
    <ul>
    @foreach($professional->medicalStudies as $ms)
        <li>{!! $ms->name !!}</li>
    @endforeach
    </ul>
</div>

<!-- Enabled Field -->
<div class="form-group">
    {!! Form::label('enabled', 'Habilitado Secretaria:') !!}
    <p>{!! $professional->enabled !!}</p>
</div>

<!-- Enabled Field -->
<div class="form-group">
    {!! Form::label('patient_enabled', 'Habilitado Pacientes:') !!}
    <p>{!! $professional->is_patient_enabled !!}</p>
</div>

<!-- Internal Id Field -->
<!-- <div class="form-group">
    {!! Form::label('internal_id', 'Internal Id:') !!}
    <p>{!! $professional->internal_id !!}</p>
</div> -->

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creado:') !!}
    <p>{!! $professional->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Última actualización:') !!}
    <p>{!! $professional->updated_at !!}</p>
</div>

