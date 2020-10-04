<!-- Surname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('surname', 'Apellido:') !!}
    {!! $history->patient_surname !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! $history->patient_name !!}
</div>

<!-- Dni Field -->
<div class="form-group col-sm-6">
    {!! Form::label('dni', 'Dni:') !!}
    {!! $history->dni !!}
</div>

<!-- Edad Field -->
<div class="form-group col-sm-6">
    {!! Form::label('edad', 'Edad:') !!}
    {!! $history->edad !!}
</div>

<!-- Domicilio Field -->
<div class="form-group col-sm-6">
    {!! Form::label('domicilio', 'Domicilio:') !!}
    {!! $history->domicilio !!}
</div>

<!-- Telefono Field -->
<div class="form-group col-sm-6">
    {!! Form::label('telefono', 'Teléfono:') !!}
    {!! $history->telefono !!}
</div>

<!-- Médico de cabecera -->
<div class="form-group col-sm-6">
    {!! Form::label('medico_cabecera', 'Médico de cabecera:') !!}
    {!! $history->medico_cabecera !!}
</div>

<!-- Ult. Visita Field -->
<div class="form-group col-sm-6">
    {!! Form::label('ultima_visita', 'Últ. Visita:') !!}
    {!! $history->ultima_visita !!}
</div>

<!-- Insurance Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('insurance_id', 'Obra social:') !!}
    {!! isset($history->os) ? $history->os->name : "" !!}
</div>
<div class="form-group col-sm-6">
    {!! Form::label('plan', 'Plan:') !!}
    {!! $history->patient_os_number !!}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('name', 'Comentarios:') !!}
    {!! $history->comments !!}
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

