<div class="row bottom-buffer">
	<div class="col-md-6">
		{!! Form::open(['route' => 'appointments.store', 'class' => 'form-inline']) !!}
			<div class="form-group">
	    		{!! Form::label('professional_id', 'Médico:') !!}
    			{!! Form::select('professional_id', ['null' => 'Seleccionar'] + $professionals, 
        			isset($appointment) ? $appointment->getProfessionalId() : 0,
        			['class' => 'form-control']) !!}
			</div>
  		{!! Form::submit('Crear Historia Clínica', ['class' => 'btn btn-primary']) !!}
		{!! Form::close() !!}
	</div>
</div>