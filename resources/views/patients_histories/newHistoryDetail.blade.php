        
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

            <h3 class="timeline-header"><a href="#">Nueva nota</a></h3>            
            <div class="timeline-body">
                @include('adminlte-templates::common.errors')
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
                <label for="exampleInputFile">Archivos adjuntos <button type="button" class="btn btn-primary btn-xs btn-add-file"><i class="glyphicon glyphicon-plus"></i>Agregar</button></label>
                <div class="archive-list">
                </div>
                <div class="file-array">
                </div>
                    
            </div>
            </div>
            <div class="timeline-footer">
                {!! Form::submit('Guardar', ['class' => 'btn btn-primary btn-xs']) !!}
            </div>
        </div>