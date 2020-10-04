<!-- Modal -->
<div class="modal fade" id="newAppointmentModal" tabindex="-1" role="dialog" 
     aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    SOLICITAR NUEVO TURNO
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <div class="col-md-6 button-div">
                    <a href="#" class="push_button red">POR TIPO DE CONSULTA</a>
                </div>
                <div class="col-md-6 button-div">
                    <a href="#" class="push_button blue">POR MEDICO</a>
                </div>
                {!! Form::open(['route' => 'patient.appointments.create', 'class' => 'form', 'id' => 'newAppointmentModalForm', 'method' => 'GET']) !!}
                <!-- Professional Id Field -->
                <div class="form-group professional-select">
                    {!! Form::label('professional_id', 'Médico:') !!}
                    {!! Form::select('professional_id', ['null' => 'Seleccionar'] + $professionals, 
                        null,
                        ['class' => 'form-control']) !!}
                </div>

                <!-- Medical Study Id Field -->
                <div class="form-group medicalstudy-select">
                    {!! Form::label('medical_study_id', 'Estudio Médico:') !!}
                    {!! Form::select('medical_study_id', ['null' => 'Seleccionar'] + $medicalStudies->pluck('name','id')->all(), 
                        null,
                        ['class' => 'form-control']) !!}
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Cancelar
                </button>


                <button type="submit" class="btn btn-primary btn-submit" style="display:none;">
                    Continuar
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>