<div class="modal fade edit-modal" tabindex="-1" role="dialog" id="editDetailModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Editar Nota</h4>
      </div>
      <div class="modal-body">

        {!! Form::open(['route' => 'detalleHistoria.update', 'id' => 'updateDetailForm', 'enctype' => 'multipart/form-data', 'method' => 'patch']) !!}
          {!! Form::hidden('detail_id', null)!!}
          {!! Form::hidden('history_id', $history->id)!!}

          <div class="form-group col-sm-12">
                    {!! Form::label('date', 'Fecha y hora:') !!}
                    {!! Form::text('date', null, ['class' => 'form-control datepicker read-only datetime-input', 'readonly' => 'readonly']) !!}
          </div>
          <div class="form-group col-sm-12">
            {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5', 'id' => 'comment', 'placeholder' => 'Descripción de la nota']) !!}
            <span class="help-block">
              * La descripción no puede estar vacía.
            </span>
          </div>

          <div class="col-sm-12 form-group">
            <label for="archive">Archivos adjuntos <button type="button" class="btn btn-primary btn-xs btn-add-file"><i class="glyphicon glyphicon-plus"></i>Agregar</button></label>
            <div class="archive-list"></div>
            <div class="file-array"></div>
                    
          </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Volver</button>
        <button type="submit" class="btn btn-primary btn-save-detail">Guardar</button>
      </div>
      {!! Form::close() !!}
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->