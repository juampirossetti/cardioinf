<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Nombre:') !!}
    <p>{!! $insurance->name !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('short_name', 'Nombre Corto:') !!}
    <p>{!! $insurance->short_name !!}</p>
</div>

<!-- Enabled Field -->
<div class="form-group">
    {!! Form::label('enabled', 'Habilitada:') !!}
    <p>{!! $insurance->enabled !!}</p>
</div>

<!-- Enabled Field -->
<div class="form-group">
    {!! Form::label('patient_enabled', 'Habilitada Pacientes:') !!}
    <p>{!! $insurance->is_patient_enabled !!}</p>
</div>

<!-- Description Field -->
<div class="form-group">
    {!! Form::label('description', 'Descripción:') !!}
    <p>{!! $insurance->description !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creada el:') !!}
    <p>{!! $insurance->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Última actualización:') !!}
    <p>{!! $insurance->updated_at !!}</p>
</div>

