{{ Form::hidden('api_token',$user->api_token)}}
{{ Form::hidden('professional_id', null) }}
{{ Form::hidden('patient_name', null) }}
{{ Form::hidden('patient_surname', null) }}
{{ Form::hidden('patient_address', null) }}
{{ Form::hidden('patient_primary_phone', null) }}
{{ Form::hidden('patient_secondary_phone', null) }}
{{ Form::hidden('patient_plan', null) }}
{{ Form::hidden('patient_email', null) }}
{{ Form::hidden('patient_affiliate_number', null) }}
{{ Form::hidden('patient_professional', null) }}
<div class="row">
<div class="col-md-6">
    <!-- Date Field -->
    <div class="form-group">
        {!! Form::label('date', 'Fecha:') !!}
        {!! Form::text('date', null, ['class' => 'form-control datepicker read-only', 'readonly' => 'readonly']) !!}
        <span class="error text-danger new-appointment-error-msg" id="new-appointment-date-error">Debe seleccionar una fecha.</span>
    </div>

    <!-- Time Field -->
    <div class="form-group">
        {!! Form::label('time', 'Hora:') !!}
        {!! Form::text('time', null, ['class' => 'form-control timepicker', 'id' => 'timepicker']) !!}
        <span class="error text-danger new-appointment-error-msg" id="new-appointment-timepicker-error">Debe seleccionar un horario.</span>
    </div>

    <!-- Status Field -->
    <div class="form-group">
        {!! Form::label('status', 'Estado:') !!}
        {!! Form::
            select('status', ['0' => 'Libre', '1' => 'Ocupado', '2' => 'Sala de espera', '3' => 'Finalizado', '4' => 'Cancelado'],
            0,
            ['class' => 'form-control']) !!}
    </div>

    <!-- Insurance Id Field -->
    <div class="form-group">
        {!! Form::label('insurance_id', 'Obra Social:') !!}
        {!! Form::select('insurance_id', ['' => 'Seleccionar'] + $insurances, 
            null,
            ['class' => 'form-control']) !!}
    </div>

    <!-- Insurance Id Field -->
    <div class="form-group">
        {!! Form::label('medical_study_id', 'Estudio Médico:') !!}
        {!! Form::select('medical_study_id', ['' => 'Seleccionar'] + $medicalStudies, 
            null,
            ['class' => 'form-control']) !!}
        <span class="error text-danger new-appointment-error-msg" id="new-appointment-medical_study_id-error">Debe seleccionar un tipo de estudio médico.</span>
    </div>

</div>

<div class="col-md-6">
    <!-- Patient Id Field -->
    <div class="form-group">
        {!! Form::label('patient_id', 'Paciente:') !!}
        <div class="input-group">
            {!! Form::hidden('patient_id', null, ['id' => 'patient_id']) !!}
            {!! Form::text('patient_show_name', null, ['class' => 'form-control readonly', 'readonly' =>    'readonly', 'id' => 'patient_show_name']) !!}
            <span class="input-group-btn">
                {!! Form::button('Busqueda', ['class' => 'btn btn-default search-patient', 'id' => 'search_patient']) !!}
                {!! Form::button('Avanzada', ['class' => 'btn btn-default advanced-search', 'id' => 'advanced_search']) !!}
            </span>
        </div>
        <span class="error text-danger new-appointment-error-msg" id="new-appointment-patient_id-error">Debe seleccionar un paciente.</span>
        <span class="error text-success patient-success-msg success-msg" for="patient_id" id="patient-success-msg">El paciente fue seleccionado correctamente.</span>
        <span class="error text-danger patient-error-msg error-msg" for="patient_id" id="patient-error-msg">Ocurrió un error guardando el paciente en nuestra base de datos. Por favor intente más tarde o comuníquese con el administrador.</span>
    </div>

    <!-- Search patient form -->
    @include('calendar.searchPatient')

    @include('calendar.advancedSearch')

    <!-- Money Field -->
    <div class="form-group">
        {!! Form::label('money', 'Depósito:') !!}
        {!! Form::number('money', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Coupons Field -->
    <div class="form-group">
        {!! Form::label('coupons', 'Cupones:') !!}
        {!! Form::number('coupons', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Money Field -->
    <div class="form-group">
        {!! Form::label('comment', 'Comentario:') !!}
        {!! Form::textarea('comment', null, ['class' => 'form-control', 'maxlength' => '255', 'cols' => '50', 'rows' => '5']) !!}
    </div>
</div>
</div>
