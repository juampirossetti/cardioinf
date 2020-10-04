{{ Form::hidden('api_token',$user->api_token)}}
<!-- Professional Id Field -->
{{ Form::hidden('professional_id', null) }}

<div class="row">
<div class="col-md-12">
    <!-- Date Field -->
    <div class="form-group">
        <div class="range-calendar">
            <div>
                {!! Form::label('date_from', 'Desde:') !!}
            </div>
        {!! Form::text('date_from', null, ['class' => 'form-control date_from']) !!}
        </div>
        <div class="range-calendar pull-right-sm">
            <div>
                {!! Form::label('date_until', 'Hasta:') !!}
            </div>
        {!! Form::text('date_until', null, ['class' => 'form-control date_until']) !!}
        </div>
    </div>
</div>
</div>
<div class="row">
<div class="col-md-12">
    <!-- Money Field -->
    <div class="form-group">
        {!! Form::label('appointments_per_turn', 'Número de turnos por fracción:') !!}
        {!! Form::number('appointments_per_turn', null, ['class' => 'form-control appointments_per_turn']) !!}
    </div>
</div>
</div>