<div class="col-sm-12">
	<form class="form-horizontal" id="appointmentSearchForm">
		<div class="row">
			<div class="form-group col-md-12">
    		{!! Form::label('patient_surname', 'Apellido:', ['class' => 'col-sm-2 control-label']) !!}
    		<div class="col-sm-10">
        	<select class="form-control patient-surname-select2" lang="es" name="s_patient_surname" id="s_patient_surname">
        	</select>
    		</div>
			</div>

			<div class="form-group col-sm-12">
    		{!! Form::label('patient_name', 'Nombre:', ['class' => 'col-sm-2 control-label']) !!}
    		<div class="col-sm-10">
        	<select class="form-control patient-name-select2" lang="es" name="s_patient_name" id="s_patient_name">
        	</select>
    		</div>
			</div>

			<div class="form-group col-sm-12">
				<button type="button" class="btn btn-primary pull-right" id="searchAppointmentButton">Buscar </button>
  		</div>
		</div>
	</form>
</div>