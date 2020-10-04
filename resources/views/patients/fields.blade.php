<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Surname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('surname', 'Apellido:') !!}
    {!! Form::text('surname', null, ['class' => 'form-control']) !!}
</div>

<!-- Dni Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dni', 'Dni:') !!}
    {!! Form::number('dni', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Dirección:') !!}
    {!! Form::text('address', null, ['class' => 'form-control']) !!}
</div>

<!-- Primary Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('primary_phone', 'Teléfono primario:') !!}
    {!! Form::text('primary_phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Secondary Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('secondary_phone', 'Teléfono secundario:') !!}
    {!! Form::text('secondary_phone', null, ['class' => 'form-control']) !!}
</div>

<!-- Insurance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insurance_id', 'Obra Social:') !!}
    {!! Form::select('insurance_id', array(null => 'Seleccionar') + $insurances, 
        isset($patient) ? $patient->getInsuranceId() : 0,
        ['class' => 'form-control']) !!}
</div>

<!-- Plan Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plan', 'Plan:') !!}
    {!! Form::text('plan', null, ['class' => 'form-control']) !!}
</div>

<!-- Affiliate Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('affiliate_number', 'N. Afiliado:') !!}
    {!! Form::text('affiliate_number', null, ['class' => 'form-control']) !!}
</div>

<!-- Insurance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('professional', 'Médico de cabecera:') !!}
    {!! Form::text('professional', null, ['class' => 'form-control']) !!}
</div>

<!-- Insurance Id Field -->
@if(isset($patient))
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    <div class="row">
        <div class="col-sm-6">
            {!! Form::email('email', 
            $patient->user != null ? $patient->user->email : '', 
            ['class' => 'form-control', 'id' => 'user_email', 
             'oninvalid' => 'this.setCustomValidity("Por favor ingrese un email válido.")']) !!}
        </div>
        <div class="col-sm-2 top-buffer-xs">
            
            {!! Form::button('Generar Contraseña', ['class' => 'btn btn-success btn-password']) !!}
            
        </div>
    </div>
</div>
@endif

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('patients.index') !!}" class="btn btn-default">Cancelar</a>
</div>


<!-- Insurance Id Field -->
@if(isset($patient))
    @include('patients.emailModal')
@endif