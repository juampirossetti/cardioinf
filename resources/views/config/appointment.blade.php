<form action="{{ route('system.update','appointment') }}" method="POST">
    <div class="row">
        <!-- general form elements disabled -->
        {{ csrf_field() }}
        
        <div class="col-md-6">
            <!-- text input -->
            <div class="form-group">
                <label>Turnos que se muestran por día al paciente
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cantidad de opciones por día que le serán mostradas a los pacientes al pedir un nuevo turno."></span>
                </label>
                {!! Form::select('number_of_appointments_in_carousel',
                                 [1 => 1, 2 => 2,3 => 3,4 => 4, 5 =>5, 6=>6, 8=>8, 10=>10, 12=>12, 15=>15], 
                                 $configs->number_of_appointments_in_carousel,
                                 ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Máximo número de turnos por profesional
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cantidad máxima de turnos simultaneos que puede tener solicitado un paciente con un mismo profesional."></span>
                </label>
                {!! Form::select('max_appointments_per_professional', 
                                 [1 => 1,2 => 2,3 => 3,4 => 4,5 => 5, 9999 => 9999],
                                 $configs->max_appointments_per_professional,
                                 ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>