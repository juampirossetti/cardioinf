<!-- Modal -->
<div class="modal fade deleteModal" id="deleteModal" tabindex="-1" role="dialog" 
     aria-labelledby="DeleteConfirmation" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Eliminar turno del calendario
                </h4>
            </div>
            
            <!-- Modal Body -->
            <div class="modal-body">
                <p>¿Esta seguro que desea eliminar este turno?</p>
                <div class="checkbox" id="confirmSendEmail">
                    <label>
                        <input type="checkbox" id="send_email"> Enviar email al paciente
                    </label>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-primary"
                        data-dismiss="modal">
                        <i class="fa fa-times"></i>Cancelar
                </button>
                <button class="btn btn-danger btn-submit">
                    <i class="fa fa-check"></i>Eliminar
                </button>
            </div>
        </div>
    </div>
</div>