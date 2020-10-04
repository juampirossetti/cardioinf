<!-- Professional Id Field -->
{!! Form::hidden('patient_id', isset($patient) ? $patient->id : $patientInsurance->patient->id) !!}

<div class="form-group col-sm-12">
    {!! Form::label('insurance_id', 'Obra social:') !!}
    {!! Form::select('insurance_id', ['null' => 'Seleccionar'] + $insurances->pluck('name','id')->all(), 
        null,
        ['class' => 'form-control select2 select2-hidden-accessible',
         'tabindex' => '-1',
         'aria-hidden' => 'true',
         'style' => 'width:100%;']) !!}
</div>

<!-- Patient Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('plan', 'Plan:') !!}
    {!! Form::text('plan', null, ['class' => 'form-control']) !!}
</div>

<!-- Patient Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', 'Número:') !!}
    {!! Form::text('number', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{{ url()->previous() }}" class="btn btn-default">Cancelar</a>
</div>

@section('scripts')
	<script type="text/javascript" src="{{ URL::asset('js/secretary/patientInsurance.create.js') }}?v={{ config('app.version') }}"></script>
@endsection