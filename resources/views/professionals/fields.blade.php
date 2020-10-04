<!-- Surname Field -->
<div class="form-group col-sm-6">
    {!! Form::label('surname', 'Apellido:') !!}
    {!! Form::text('surname', null, ['class' => 'form-control']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Nombre:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<!-- Speciality Field -->
<div class="form-group col-sm-6">
    {!! Form::label('speciality', 'Especialidad:') !!}
    {!! Form::text('speciality', null, ['class' => 'form-control']) !!}
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('enabled', 'Habilitado Secretaria:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('enabled', 0, ['id'  => 'hidden_enabled']) !!}
        {!! Form::checkbox('enabled', 1, isset($professional) ? $professional->isEnabled() : true) !!}
    </label>
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('patient_enabled', 'Habilitado Pacientes:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('patient_enabled', 0, ['id'  => 'hidden_enabled']) !!}
        {!! Form::checkbox('patient_enabled', 1, isset($professional) ? $professional->isPatientEnabled() : true) !!}
    </label>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('medical_studies', 'Consultas que realiza:') !!}
    {!! Form::select('medical_studies[]', array('null' => 'Ninguna') + $medicalStudies->pluck('name','id')->all(), 
        isset($professional) ? $professional->medicalStudies->pluck('id')->all() : 0,
        ['class' => 'form-control', 'multiple' => ""]) !!}
    <h5><span class="">Mantenga presionado Ctrl para selección múltiple</span></h5>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('insurances', 'OS que atiende:') !!}
    {!! Form::select('insurances[]', array('null' => 'Ninguna') + $insurances->pluck('name','id')->all(), 
        isset($professional) ? $professional->insurances->pluck('id')->all() : 0,
        ['class' => 'form-control', 'multiple' => "", 'id' => 'insurances_select']) !!}
    <h5>
        <span class="">Mantenga presionado Ctrl para selección múltiple.</span>
        <button type="button" class="btn btn-success btn-sm pull-right select-all">Seleccionar todas</button>
    </h5>
</div>

<!-- Email Field -->
@if(SMConfig::getByKey('professional_section_enabled') == 1)
    @if(isset($professional))
    <div class="form-group col-sm-6">
        {!! Form::label('email', 'Email:') !!}
        <div class="row">
            <div class="col-sm-6">
                {!! Form::email('email', 
                    $professional->user != null ? $professional->user->email : '', 
                        ['class' => 'form-control', 'id' => 'user_email', 
                        'oninvalid' => 'this.setCustomValidity("Por favor ingrese un email válido.")']) !!}
            </div>
            <div class="col-sm-2 top-buffer-xs">
            
                {!! Form::button('Generar Contraseña', ['class' => 'btn btn-success btn-password']) !!}
            
            </div>
        </div>
    </div>
    @endif
@endif
<!-- Internal Id Field -->
<!-- <div class="form-group col-sm-6">
    {!! Form::label('internal_id', 'Internal Id:') !!}
    {!! Form::text('internal_id', null, ['class' => 'form-control']) !!}
</div> -->

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('professionals.index') !!}" class="btn btn-default">Cancelar</a>
</div>

<!-- Insurance Id Field -->
@if(isset($professional))
    @include('professionals.emailModal')
@endif