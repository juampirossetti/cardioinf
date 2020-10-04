<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Short Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('short_name', 'Nombre Corto:') !!}
    {!! Form::text('short_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('enabled', 'Habilitada:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('enabled', 0, ['id'  => 'hidden_enabled']) !!}
        {!! Form::checkbox('enabled', 1, isset($insurance) ? $insurance->isEnabled() : true) !!}
    </label>
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('patient_enabled', 'Habilitada Pacientes:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('patient_enabled', 0, ['id'  => 'hidden_enabled']) !!}
        {!! Form::checkbox('patient_enabled', 1, isset($insurance) ? $insurance->isPatientEnabled() : true) !!}
    </label>
</div>

<!-- Description Field -->
<div class="form-group col-sm-12 col-lg-12">
    {!! Form::label('description', 'Descripción:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('insurances.index') !!}" class="btn btn-default">Cancelar</a>
</div>
