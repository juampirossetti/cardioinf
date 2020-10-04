<!-- Professional Id Field -->
{{ Form::hidden('id', null, ['id' => 'invisible_id']) }}

{{ Form::hidden('api_token',$user->api_token)}}
<div class="row">
<div class="col-md-12">    
    <!-- Insurance Field -->
    <p><strong>Fecha y hora: </strong><span id="patient-datetime"></span></p>
    <p><strong>Paciente: </strong><span id="patient-name"></span></p>
    <span class="hidden" id="search-surname"></span>
    <p><strong>Obra Social: </strong><span id="patient-os"></span></p>
    <p><strong>Estudio médico: </strong><span id="patient-ms"></span></p>
    <!-- Money Field -->
    <div class="form-group">
        {!! Form::label('comment', 'Comentario:') !!}
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'maxlength' => '255', 'cols' => '50', 'rows' => '5', 'id' => 'patient-comment']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('status', 'Estado:') !!}
            {!! Form::select('status', 
            ['0' => 'Libre', '1' => 'Ocupado', '2' => 'Sala de espera', '3' => 'Finalizado', '4' => 'Cancelado'],
            null,
            ['class' => 'form-control', 'id' => 'patient-status']) !!}
    </div>
</div>
</div>