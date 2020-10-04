<div class="col-sm-6">
    <div class="row">
        <!-- Date Field -->
        <div class="form-group col-sm-6">
            {!! Form::label('date', 'Fecha:') !!}
            {!! Form::text('date', null, ['class' => 'form-control datepicker read-only', 'readonly' => 'readonly']) !!}
        </div>
        <!-- Professional Id Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('professional_id', 'Médico:') !!}
            {!! Form::select('professional_id', array('null' => 'Seleccionar') + $professionals->pluck('complete_name','id')->all(), 
                isset($exceptionDay) ? $exceptionDay->professional->id : 0,
                ['class' => 'form-control']) !!}
        </div>
        
        <div class="form-group col-sm-12">
            {!! Form::label('medical_studies', 'Consultas que realiza:') !!}
            {!! Form::select('medical_studies[]', array('null' => 'Ninguna') + $medicalStudies->pluck('name','id')->all(), 
                isset($exceptionDay) ? $exceptionDay->medicalStudies->pluck('id')->all() : 0,
                ['class' => 'form-control', 'multiple' => ""]) !!}
            <h5><span class="">Mantenga presionado Ctrl para selección múltiple</span></h5>
        </div>
    </div>

    <!-- Submit Field -->
    <div class="form-group col-sm-12">
        {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! route('exceptionsdays.index') !!}" class="btn btn-default">Cancelar</a>
    </div>

</div>