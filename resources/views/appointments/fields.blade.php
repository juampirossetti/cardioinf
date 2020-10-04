<!-- Date Field -->
<div class="form-group col-sm-6">
    {!! Form::label('date', 'Fecha:') !!}
    {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'datepicker']) !!}
</div>

<!-- Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('time', 'Hora:') !!}
    {!! Form::text('time', null, ['class' => 'form-control', 'id' => 'timepicker']) !!}
</div>

<!-- Money Field -->
<div class="form-group col-sm-6">
    {!! Form::label('money', 'Depósito:') !!}
    {!! Form::number('money', null, ['class' => 'form-control']) !!}
</div>

<!-- Coupons Field -->
<div class="form-group col-sm-6">
    {!! Form::label('coupons', 'Cupones:') !!}
    {!! Form::number('coupons', null, ['class' => 'form-control']) !!}
</div>

<!-- Insurance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insurance_id', 'Obra Social:') !!}
    {!! Form::select('insurance_id', ['null' => 'Seleccionar'] + $insurances, 
        isset($appointment) ? $appointment->insurance_id : 0,
        ['class' => 'form-control']) !!}
</div>

<!-- Study Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('medical_study_id', 'Estudio médico:') !!}
    {!! Form::select('medical_study_id', ['null' => 'Seleccionar'] + $medicalStudies, 
        isset($appointment) ? $appointment->medical_study_id : 0,
        ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Estado:') !!}
    {!! Form::
            select('status', ['null' => 'Seleccionar', '0' => 'Libre', '1' => 'Ocupado', '2' => 'Espera', '3' => 'Finalizado'],
            isset($appointment) ? $appointment->status_id : null,
            ['class' => 'form-control']) !!}
</div>

<!-- Professional Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('professional_id', 'Médico:') !!}
    {!! Form::select('professional_id', ['null' => 'Seleccionar'] + $professionals, 
        isset($appointment) ? $appointment->getProfessionalId() : 0,
        ['class' => 'form-control']) !!}
</div>

<!-- Patient Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('patient_id', 'Paciente:') !!}
    {!! Form::select('patient_id', ['null' => 'Seleccionar'] + $patients, 
        isset($appointment) ? $appointment->getPatientId() : 0,
        ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('appointments.index') !!}" class="btn btn-default">Cancelar</a>
</div>
