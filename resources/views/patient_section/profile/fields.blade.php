<div class="col-md-12">
    <div class="callout callout-info">
        <h4><i class="icon fa fa-info" style="margin-right: 10px;"></i>Información importante</h4>
        <p>Los datos que se muestran en esta sección son los que actualmente están cargados en nuestro sistema. Sólamente puede modificar algunos campos. Si su nombre, apellido o dni son incorrectos, por favor infórmelo a la secretaria de la clínica.</p>
        <p>Muchas gracias.</p>
    </div>
</div>
<div class="col-md-12">
    @include('adminlte-templates::common.errors')
</div>
    <!-- Name Field -->
<div class="col-lg-4 col-md-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('name', 'Nombre y Apellido:') !!}
        {!! Form::text('name', $user->patient->getCompleteName(), ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>

    <!-- Dni Field -->
    <div class="form-group">
        {!! Form::label('dni', 'Dni:') !!}
        {!! Form::text('dni', $user->patient->dni, ['class' => 'form-control', 'disabled' => 'disabled']) !!}
    </div>

    <!-- Address Field -->
    <div class="form-group">
        {!! Form::label('address', 'Dirección:') !!}
        {!! Form::text('address', $user->patient->address, ['class' => 'form-control']) !!}
    </div>

    <!-- Primary Phone Field -->
    <div class="form-group">
        {!! Form::label('primary_phone', 'Teléfono principal:') !!}
        {!! Form::text('primary_phone', $user->patient->primary_phone, ['class' => 'form-control']) !!}
    </div>

    <!-- Secondary_phone Field -->
    <div class="form-group">
        {!! Form::label('secondary_phone', 'Teléfono secundario:') !!}
        {!! Form::text('secondary_phone', $user->patient->secondary_phone, ['class' => 'form-control']) !!}
    </div>
    
    <!-- Insurance Id Field -->
    <div class="form-group">
        {!! Form::label('insurance_id', 'Obra Social:') !!}
        {!! Form::select('insurance_id', ['null' => 'Seleccionar'] + $insurances->pluck('name','id')->all(), 
            isset($user->patient->insurance_id) ? $user->patient->insurance_id : null,
            ['class' => 'form-control select2 select2-hidden-accessible',
            'tabindex' => '-1',
            'aria-hidden' => 'true',
            'style' => 'width:100%;']) !!}
    </div>
    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! url('/patient') !!}" class="btn btn-default pull-right">Volver</a>
    </div>
</div>

@section('scripts')
    <script type="text/javascript" src="{{ URL::asset('js/patient/patientProfile.edit.js') }}"></script>
@endsection