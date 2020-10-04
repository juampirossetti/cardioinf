<!-- Modal -->
<div class="modal fade" id="modalEditAppointment" tabindex="-1" role="dialog" 
     aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <span id="editModalProfessionalName"></span> - <span id="editModalDate"></span> - <span id="editModalTime"></span> 
                </h4>
                <span id="appointment-owner" class="text-danger" class="hidden">El turno lo pidió el usuario <span id="owner-email"></span> para otro paciente</span>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                {!! Form::open(['route' => null, 'class' => 'form', 'id' => 'editAppointmentModalForm']) !!}
                  @include('calendar.editAppointmentFields')
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" id="btn-liberar">
                            Liberar
                </button>

                <button id="send-email-btn" type="button" class="btn btn-default send-email-btn">
                    <i class="glyphicon glyphicon-envelope"></i>
                </button>

                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Cancelar
                </button>


                <button type="submit" class="btn btn-primary" id="btnSubmitEditModal">
                    Guardar
                </button>
            </div>
            {!! Form::close() !!}
            <!-- New patient form-->

        </div>
    </div>
</div>