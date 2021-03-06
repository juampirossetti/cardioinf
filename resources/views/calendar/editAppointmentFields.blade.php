<!-- Professional Id Field -->
{{ Form::hidden('id', null, ['id' => 'invisible_id']) }}

{{ Form::hidden('api_token',$user->api_token)}}
<div class="row">
<div class="col-md-12 buscar-turnos-calendar">    
    <button type="button" class="btn btn-link pull-right" id="turnos-anteriores">
        <span class="fa fa-chevron-down" id="chevron-down"></span>
        <span class="fa fa-chevron-up" id="chevron-up" style="display:none"></span>
        Buscar turnos anteriores</button>
    @include('calendar.search_appointments.searchAppTable')
</div>
<div class="col-md-6">    
    <!-- Insurance Field -->
    <div class="form-group">
        {!! Form::label('insurance_id', 'Obra Social:') !!}
        {!! Form::select('insurance_id', [null => 'Seleccionar'] + $insurances, 
            null,
            ['class' => 'form-control edit-insurance-select']) !!}
    </div>

    <!-- Insurance Field -->
    <div class="form-group">
        {!! Form::label('medical_study_id', 'Estudio Médico:') !!}
        {!! Form::select('medical_study_id', [null => 'Seleccionar'] + $medicalStudies, 
            null,
            ['class' => 'form-control']) !!}
    </div>
    
    <!-- Status Field -->
    <div class="form-group">
        {!! Form::label('status', 'Estado:') !!}
    {!! Form::select('status', 
            ['0' => 'Libre', '1' => 'Ocupado', '2' => 'Sala de espera', '3' => 'Finalizado', '4' => 'Cancelado'],
            null,
            ['class' => 'form-control']) !!}
    </div>

    <!-- Order Number Field -->
    <div class="form-group">
        {!! Form::label('order_number', 'N. Orden:') !!}
        {!! Form::number('order_number', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
    {!! Form::label('user_id', 'Usuario:') !!}
    <div>
        <select class="js-data-example-ajax form-control app-user-select2" lang="es" name="user_id" id="appUserSelect">
        </select>
    </div>
</div>
</div>
<div class="col-md-6">
    <!-- Patient Id Field -->
    <div class="form-group">
        {!! Form::label('patient_id', 'Paciente:') !!}
        <div class="input-group">
            {!! Form::hidden('patient_id', null, ['id' => 'patient_id']) !!}
            {!! Form::text('patient_show_name', null, ['class' => 'form-control readonly', 'readonly' => 'readonly', 'id' => 'patient_show_name']) !!}
            <span class="input-group-btn">
                {!! Form::button('Busqueda', ['class' => 'btn btn-default search-patient', 'id' => 'search_patient']) !!}
                {!! Form::button('Avanzada', ['class' => 'btn btn-default advanced-search', 'id' => 'advanced_search']) !!}
            </span>
        </div>
        <span class="error text-success success-msg" for="patient_id" id="patient-success-msg">El paciente fue seleccionado correctamente.</span>
        <span class="error text-danger error-msg" for="patient_id" id="patient-error-msg">Ocurrió un error guardando el paciente en nuestra base de datos. Por favor intente más tarde o comuníquese con el administrador.</span>
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
