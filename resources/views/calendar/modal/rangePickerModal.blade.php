<!-- Modal -->
<div class="modal fade" id="rangePickerModal" tabindex="-1" role="dialog" 
     aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                       <span aria-hidden="true">&times;</span>
                       <span class="sr-only">Cerrar</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Seleccione un rango de fechas
                </h4>
            </div>
            <!-- Modal Body -->
            <div class="modal-body">
            {!! Form::open(['route' => 'api.calendar.bulkAction', 'class' => 'form', 'id' => 'rangePickerForm']) !!}
                {{ Form::hidden('api_token',$user->api_token)}}
                <!-- Professional Id Field -->
                {{ Form::hidden('professional_id', null) }}
                {{ Form::hidden('action', null) }}

                <div class="row">
                    <div class="col-md-12">
                    <!-- Date Field -->
                        <div class="form-group">
                            <div class="range-calendar">
                                <div>
                                    {!! Form::label('date_from', 'Desde:') !!}
                                </div>
                                {!! Form::text('date_from', null, ['class' => 'form-control date_from']) !!}
                            </div>
                            <div class="range-calendar pull-right-sm">
                                <div>
                                    {!! Form::label('date_until', 'Hasta:') !!}
                                </div>
                                {!! Form::text('date_until', null, ['class' => 'form-control date_until']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="send_email" name="send_email" value="1"> Enviar email a los pacientes
                                <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="En caso de que algún turno este ocupado, se le enviará un email al paciente informándole el cambio."></span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-cancel"
                        data-dismiss="modal">
                            Cancelar
                </button>
                <button type="submit" class="btn btn-primary">
                    Aceptar
                </button>
            </div>
            </form>
        </div>
    </div>
</div>