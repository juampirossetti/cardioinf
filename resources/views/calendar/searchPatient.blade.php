<div class="panel panel-primary searchpatient-panel">
  <div class="panel-body form-horizontal">
    <div class="form-group">
        {!! Form::label('patient_dni', 'Dni:', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-xs-12 col-sm-8">
        <div class="input-group">
            {!! Form::number('patient_dni',null, ['class' => 'form-control col-sm-10 patient-dni']) !!}
            <span class="input-group-btn">
              {!! Form::button('Buscar', ['class' => 'btn btn-default search-dni', 'id' => 'search_dni']) !!}
             </span>
        </div>
            <span class="msg error text-danger error-msg search-error-msg" id="search-error-msg">Dni no encontrado. Complete los datos a continuación y presione Aceptar para dar de alta un nuevo paciente.</span>
            <span class="msg error text-success success-msg search-success-msg" id="search-success-msg"">Dni encontrado. Presione Aceptar para continuar</span>
            <span class="msg info text-success info-msg search-info-msg" id="search-info-msg"">Presione Buscar antes de cargar un paciente para asegurarse que el dni no se encuentra registrado.</span>
        
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('patient_surname', 'Apellido:', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('patient_surname',null, ['class' => 'form-control col-sm-10 patient-surname']) !!}
        </div>
    </div>

    <div class="form-group">
        {!! Form::label('patient_name', 'Nombre:', ['class' => 'col-sm-4 control-label']) !!}
        <div class="col-sm-8">
            {!! Form::text('patient_name',null, ['class' => 'form-control col-sm-10 patient-name']) !!}
        </div>
    </div>

<!-- Address Field -->
<div class="form-group">
    {!! Form::label('patient_address', 'Dirección:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::text('patient_address', null, ['class' => 'form-control col-sm-10 patient-address']) !!}
    </div>
</div>

<!-- Primary Phone Field -->
<div class="form-group">
    {!! Form::label('patient_primary_phone', 'Tel. primario:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::text('patient_primary_phone', null, ['class' => 'form-control col-sm-10 patient-primary-phone']) !!}
    </div>
</div>

<!-- Secondary Phone Field -->
<div class="form-group">
    {!! Form::label('patient_secondary_phone', 'Tel. secundario:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::text('patient_secondary_phone', null, ['class' => 'form-control col-sm-10 patient-secondary-phone']) !!}
    </div>
</div>

<!-- Insurance Id Field -->
<div class="form-group">
    {!! Form::label('patient_insurance_id', 'Obra Social:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::select('patient_insurance_id', array(null => 'Seleccionar') + $insurances, 
        0,
        ['class' => 'form-control col-sm-10 patient-insurance-id col-sm-10']) !!}
    </div>
</div>

<!-- Plan Field -->
<div class="form-group">
    {!! Form::label('patient_plan', 'Plan:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::text('patient_plan', null, ['class' => 'form-control col-sm-10 patient-plan']) !!}
    </div>
</div>

<!-- Affiliate Number Field -->
<div class="form-group">
    {!! Form::label('patient_affiliate_number', 'N. Afiliado:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::text('patient_affiliate_number', null, ['class' => 'form-control col-sm-10 patient-affiliate-number']) !!}
    </div>
</div>

<!-- Insurance Id Field -->
<div class="form-group">
    {!! Form::label('patient_professional', 'Médico de cabecera:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::text('patient_professional', null, ['class' => 'form-control col-sm-10 patient-professional']) !!}
    </div>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('patient_email', 'Email:', ['class' => 'col-sm-4 control-label']) !!}
    <div class="col-sm-8">
      {!! Form::text('patient_email', null, ['class' => 'form-control col-sm-10 patient-email']) !!}
    </div>
</div>
<a href="#" class="pull-right patient-edit-link" target="_blank">Editar paciente</a>
  </div>
  <div class="panel-footer">
      <button type="button" class="btn btn-xs btn-primary search-confirm" id="search_confirm">Aceptar</button>
      <button type="button" class="btn btn-xs btn-default search-cancel" id="search_cancel">Cancelar</button>
      <button type="button" class="btn btn-xs btn-link new-patient" id="new_patient">Nuevo Paciente</button>

  </div>
</div>