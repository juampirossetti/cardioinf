<!-- Surname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('surname', 'Apellido:') !!}
    {!! $history->patient->surname !!}
</div>

<!-- Dni Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dni', 'Dni:') !!}
    {!! $history->patient->dni !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! $history->patient->name !!}
</div>

<!-- Insurance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insurance_id', 'Obra social:') !!}
    {!! $history->patient->getInsurance() !!}
    {!! Form::label('plan', 'Plan:') !!}
    {!! $history->patient->plan !!}
</div>

<!-- Created At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('created_at', 'Historia creada el:') !!}
    {!! $history->created_at !!}
</div>

<!-- Updated At Field -->
<div class="form-group col-sm-6">
    {!! Form::label('updated_at', 'Última actualización:') !!}
    {!! $history->updated_at !!}
</div>

