<div class="col-sm-6">
    <div class="row">
        <div class="form-group col-sm-12">
            {!! Form::label('medical_study_id', 'Estudio Médico:') !!}
            {!! Form::select('medical_study_id', array('null' => 'Seleccionar') + $medicalStudies, 
                isset($indication) ? $indication->medicalStudy->id : 0,
                ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-12">
            {!! Form::label('insurance_id', 'Obra Social:') !!}
            {!! Form::select('insurance_id', array(null => 'Todas') + $insurances, 
                isset($indication->insurance) ? $indication->insurance->id : 0,
                ['class' => 'form-control']) !!}
        </div>

        <!-- Surname Field -->
        <div class="form-group col-md-12">
           {!! Form::label('message', 'Mensaje para el paciente:') !!}
            {!! Form::textarea('message', isset($indication->message) ? $indication->message : '', [
              'class' => 'form-control',
                'rows' => '5',
                'maxlength' => '1024']) !!}
        </div>

        <!-- Enabled Field -->
        <div class="form-group col-sm-12">
            {!! Form::label('enabled_appointment', 'Permitir solicitar turno') !!}
            <label>
                {!! Form::hidden('enabled_appointment', 0, ['id'  => 'hidden_enabled_appointment']) !!}
                {!! Form::checkbox('enabled_appointment', 1, isset($indication) ? $indication->enabled_appointment : true) !!}
            </label>
            <h5><span class="">Si esta casilla esta desmarcada, cuando el paciente seleccione la obra social se le mostrará el mensaje escrito anteriormente y no podrá solicitar turno.</span></h5>
        </div>
        <!-- Submit Field -->
        <div class="form-group col-sm-12">
            {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
            <a href="{!! route('indications.index') !!}" class="btn btn-default">Cancelar</a>
        </div>
    </div>
</div>