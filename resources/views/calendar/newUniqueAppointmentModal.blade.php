<!-- Modal -->
<div class="modal fade" id="uniqueAppointmentModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Habilitar turno - <span id="professionalName"></span>
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                {!! Form::open(['route' => 'api.appointments.store', 'class' => 'form', 'id' => 'uniqueAppointmentModalForm']) !!}
                  @include('calendar.newUniqueAppointmentFields')
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>