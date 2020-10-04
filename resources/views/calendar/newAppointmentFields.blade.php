<!-- Professional Id Field -->
{{ Form::hidden('api_token',$user->api_token)}}
{{ Form::hidden('professional_id', null) }}
{{ Form::hidden('date_from', null) }}
{{ Form::hidden('date_until', null) }}
<!-- Money Field -->
<div class="form-group">
    {!! Form::label('appointments_per_turn', 'Número de turnos por fracción:') !!}
    {!! Form::number('appointments_per_turn', null, ['class' => 'form-control']) !!}
</div>