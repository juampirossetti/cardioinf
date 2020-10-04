<!-- Date Field -->
<div class="form-group">
    {!! Form::label('date', 'Fecha:') !!}
    <p>{!! $appointment->date !!}</p>
</div>

<!-- Time Field -->
<div class="form-group">
    {!! Form::label('time', 'Hora:') !!}
    <p>{!! $appointment->time !!}</p>
</div>

<!-- Money Field -->
<div class="form-group">
    {!! Form::label('money', 'Depósito:') !!}
    <p>{!! $appointment->money !!}</p>
</div>

<!-- Coupons Field -->
<div class="form-group">
    {!! Form::label('coupons', 'Cupones:') !!}
    <p>{!! $appointment->coupons !!}</p>
</div>

<!-- Insurance Field -->
<div class="form-group">
    {!! Form::label('insurance', 'Obra Social:') !!}
    <p>{!! $appointment->insurance !!}</p>
</div>

<!-- Status Field -->
<div class="form-group">
    {!! Form::label('status', 'Estado:') !!}
    <p>{!! $appointment->status !!}</p>
</div>

<!-- Professional Id Field -->
<div class="form-group">
    {!! Form::label('professional_id', 'Médico:') !!}
    <p>{!! $appointment->professional_id !!}</p>
</div>

<!-- Patient Id Field -->
<div class="form-group">
    {!! Form::label('patient_id', 'Paciente:') !!}
    <p>{!! $appointment->patient_id !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Creado el:') !!}
    <p>{!! $appointment->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Última actualización:') !!}
    <p>{!! $appointment->updated_at !!}</p>
</div>

