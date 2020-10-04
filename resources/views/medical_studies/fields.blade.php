<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('acronym', 'Acrónimo:') !!}
    {!! Form::text('acronym', null, ['class' => 'form-control']) !!}
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('enabled', 'Habilitado:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('enabled', 0) !!}
        {!! Form::checkbox('enabled', 1, isset($medicalStudy) ? $medicalStudy->isEnabled() : true) !!}
    </label>
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('enabled', 'Habilitado Pacientes:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('patient_enabled', 0) !!}
        {!! Form::checkbox('patient_enabled', 1, isset($medicalStudy) ? $medicalStudy->isPatientEnabled() : true) !!}
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
    <a href="{!! route('medicalStudies.index') !!}" class="btn btn-default">Cancelar</a>
</div>
