<div class="col-sm-12">
<form class="form-horizontal" id="appointmentSearchForm">
<div class="search-box row">
	<h4>Búsqueda por Apellido y Nombre</h4>
	
	<div class="form-group col-sm-12">
    {!! Form::label('patient_surname', 'Apellido:', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <select class="form-control patient-surname-select2" lang="es" name="patient_surname" id="patient_surname">
        </select>
    </div>
	</div>
	
	<div class="form-group col-sm-12">
    {!! Form::label('patient_name', 'Nombre:', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <select class="form-control patient-name-select2" lang="es" name="patient_name" id="patient_name">
        </select>
    </div>
	</div>

	<h4>Búsqueda por DNI</h4>
    <span class="help-block text-center"> Sólo para turnos que hayan cargado el DNI al pedirlos</span>
	<div class="form-group col-sm-12">
    {!! Form::label('patient_dni', 'Dni Paciente:', ['class' => 'col-sm-2 control-label']) !!}
    <div class="col-sm-10">
        <select class="form-control patient-dni-select2" lang="es" name="patient_dni" id="patient_dni">
        </select>
    </div>
	</div>
	<div class="form-group col-sm-12">
		{!! Form::submit('Buscar', ['class' => 'btn btn-primary pull-right']) !!}
  </div>
</div>
</form>
</div>