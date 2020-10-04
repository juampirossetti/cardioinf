<!-- Surname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('surname', 'Apellido:') !!}
    {!! $patient->surname !!}
</div>

<!-- Dni Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dni', 'Dni:') !!}
    {!! $patient->dni !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! $patient->name !!}
</div>

<!-- Address Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address', 'Dirección:') !!}
    {!! $patient->address !!}
</div>

<!-- Primary Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('primary_phone', 'Teléfono primario:') !!}
    {!! $patient->primary_phone !!}
</div>

<!-- Secondary Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('secondary_phone', 'Teléfono secundario:') !!}
    {!! $patient->secondary_phone !!}
</div>

<!-- Insurance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insurance_id', 'Obra social:') !!}
    {!! $patient->getInsurance() !!}
</div>

<!-- Plan Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plan', 'Plan:') !!}
    {!! $patient->plan !!}
</div>

<!-- N. Afiliado Field -->
<div class="form-group col-sm-6">
    {!! Form::label('affiliate_number', 'N. Afiliado:') !!}
    {!! $patient->affiliate_number !!}
</div>

<!-- Professional Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('professional', 'Médico de cabecera:') !!}
    {!! $patient->professional !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Creado el:') !!}
    {!! $patient->created_at !!}
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Última actualización:') !!}
    {!! $patient->updated_at !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-12">
    {!! Form::label('email', 'Email:') !!}
    @if(!empty($patient->user))
        {!! $patient->user->email !!}
    @else
        'No asignado'
    @endif
</div>

