<div class="form-group col-sm-12">
    @if(isset($history))
    <input type="hidden" value="{{$history->professional_id}}" name="professional_id">
    @else
    <input type="hidden" value="{{$professional_id}}" name="professional_id">
    @endif
</div>

<div class="form-group col-sm-6">
    {!! Form::label('patient_surname', 'Apellido:') !!}
    {!! Form::text('patient_surname', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('patient_name', 'Nombre:') !!}
    {!! Form::text('patient_name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('dni', 'Dni:') !!}
    {!! Form::text('dni', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('edad', 'Edad:') !!}
    {!! Form::text('edad', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('domicilio', 'Domicilio:') !!}
    {!! Form::text('domicilio', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('telefono', 'Teléfono:') !!}
    {!! Form::text('telefono', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('medico_cabecera', 'Médico de cabecera:') !!}
    {!! Form::text('medico_cabecera', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('ultima_visita', 'Última Visita:') !!}
    {!! Form::text('ultima_visita', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('patient_od', 'Obra Social:') !!}
    <div>
        <select class="js-data-example-ajax form-control os-select2" lang="es" name="patient_os">
        </select>
    </div>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('patient_os_number', 'N. Afiliado:') !!}
    {!! Form::text('patient_os_number', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Usuario:') !!}
    <div>
        <select class="js-data-example-ajax form-control user-select2" lang="es" name="user_id">
        </select>
    </div>
</div>

<div class="form-group col-sm-12">
    {!! Form::label('comments', 'Observaciones:') !!}
    {!! Form::textarea('comments', null, ['class' => 'form-control']) !!}
</div>
