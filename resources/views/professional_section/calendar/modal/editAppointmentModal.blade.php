<!-- Modal -->
<div class="modal fade" id="editAppointmentModal" tabindex="-1" role="dialog" 
     aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"> Datos del turno</h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                {!! Form::open(['route' => null, 'class' => 'form', 'id' => 'editAppointmentModalForm']) !!}
                  @include('professional_section.calendar.modal.editAppointmentModalFields')
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                @if(Auth::user()->professional->id != 2)
                <a href="{{ route('historias.index')}}" target="_blank"><button type="button" class="btn btn-default pull-left search-historia">
                            Buscar Historia
                </button>
                @endif

                <button type="button" class="btn btn-default"
                        data-dismiss="modal">
                            Cancelar
                </button>


                <button type="submit" class="btn btn-primary">
                    Guardar
                </button>
            </div>
            {!! Form::close() !!}
            <!-- New patient form-->

        </div>
    </div>
</div>