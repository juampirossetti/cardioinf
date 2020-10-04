<div class="form-group col-sm-12">
    {!! Form::label('professional', 'Médico:') !!}
    {{$insuranceException->professional->getCompleteName()}}
</div>

<div class="form-group col-sm-12">
    {!! Form::label('insurance', 'Obra Social:') !!}
    {{$insuranceException->insurance->name}}
</div>

<!-- Surname Field -->
<div class="form-group col-md-6">
    {!! Form::label('message', 'Mensaje para el paciente:') !!}
    {!! Form::textarea('message', isset($insuranceException->message) ? $insuranceException->message : '', [
        'class' => 'form-control',
        'rows' => '5',
        'maxlength' => '256']) !!}
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('enabled_patient', 'Mostrar en nuevo turno de paciente:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('enabled_patient', 0, ['id'  => 'hidden_enabled_patient']) !!}
        {!! Form::checkbox('enabled_patient', 1, isset($insuranceException) ? $insuranceException->enabled_patient : true) !!}
    </label>
    <h5><span class="">Si esta casilla esta desmarcada, la obra social no se mostrará en la lista de obras sociales que se muestran al pedir un nuevo turno.</span></h5>
</div>

<!-- Enabled Field -->
<div class="form-group col-sm-12">
    {!! Form::label('enabled_appointment', 'Permitir solicitar turno:') !!}
    <label class="checkbox-inline">
        {!! Form::hidden('enabled_appointment', 0, ['id'  => 'hidden_enabled_appointment']) !!}
        {!! Form::checkbox('enabled_appointment', 1, isset($insuranceException) ? $insuranceException->enabled_appointment : true) !!}
    </label>
    <h5><span class="">Si esta casilla esta desmarcada, cuando el paciente seleccione la obra social se le mostrará el mensaje escrito anteriormente y no podrá solicitar turno.</span></h5>
</div>
<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Guardar', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('professionals.edit', $insuranceException->professional->id) !!}" class="btn btn-default">Cancelar</a>
</div>