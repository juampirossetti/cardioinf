<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{!! $medicalStudy->name !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('acronym', 'Nombre:') !!}
    <p>{!! $medicalStudy->acronym !!}</p>
</div>

<!-- Enabled Field -->
<div class="form-group">
    {!! Form::label('enabled', 'Habilitado:') !!}
    <p>{!! $medicalStudy->is_enabled !!}</p>
</div>

<!-- Enabled Field -->
<div class="form-group">
    {!! Form::label('patient_enabled', 'Habilitado Paciente:') !!}
    <p>{!! $medicalStudy->is_patient_enabled !!}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Descripción:') !!}
    <p>{!! $medicalStudy->description !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Fecha de creación:') !!}
    <p>{!! $medicalStudy->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Última modificación:') !!}
    <p>{!! $medicalStudy->updated_at !!}</p>
</div>

