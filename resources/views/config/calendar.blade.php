
<form action="{{ route('system.update','calendar') }}" method="POST" id="calendarForm">
    <div class="row">
    <!-- general form elements disabled -->
    {{ csrf_field() }}
        <div class="col-md-6">
            <!-- text input -->
            <div class="form-group">
                <label>Cantidad de meses previos en el calendario
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cantidad de meses previos al día actual que mostrará el calendario de la secretaria."></span>
                </label>
                {!! Form::select('showmonthsbefore',
                                 [3 => 3,6 => 6, 12 => 12,18 => 18,24 => 24], 
                                 $configs->showmonthsbefore,
                                 ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-6">
            <!-- text input -->
            <div class="form-group">
                <label>Cantidad de meses posteriores en el calendario
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Cantidad de meses posteriores al día actual que mostrará el calendario de la secretaria."></span>
                </label>
                {!! Form::select('showmonthsafter',
                                 [3 => 3,6 => 6, 12 => 12,18 => 18,24 => 24], 
                                 $configs->showmonthsafter,
                                 ['class' => 'form-control']) !!}
            </div>
        </div>

        <div class="col-md-6">
            <!-- text input -->
            <div class="form-group">
                <label>Alerta de turnos en disponibilidad baja
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="El calendario indicará con color cuando la cantidad de turnos disponibles sea menor a la seleccionada."></span>
                </label>
                {!! Form::select('max_media_disponibility',
                                 [1 => 1, 2 => 2,3 => 3,4 => 4, 5 =>5, 6=>6, 8=>8, 10=>10, 12=>12, 15=>15], 
                                 $configs->max_media_disponibility,
                                 ['class' => 'form-control']) !!}
            </div>
        </div>
    <!-- text input -->
    <div class="col-md-6 col-md-offset-3">
        <p>Configurar los horarios de inicio y fin del calendario (para la secretaria)</p>
        <ul class="alert alert-danger calendar-error" style="list-style-type: none; display:none;">
            <li class="empty-time" style="display:none;">Formato incorrecto de horario. Ningún horario puede estar vacío.</li>
            <li class="incompatible-time" style="display:none;">El horario de inicio debe ser menor al horario de fin.</li>
        </ul>
        <table class="table borderless calendar-time">
            <thead>
            <tr>
                <th>Día</th>
                <th>Inicio</th>
                <th>Fin</th>
            </tr>
            </thead>

            <tbody>
                @foreach($days as $day)
                <tr>
                    <td>{{$day}}</td>
                    <td>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </div>
                                <input type="text" name="calendar[start][{{$loop->index}}]" class="form-control timepicker" data-time="{{$configs->start_hours[$loop->index]}}">
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </div>
                                <input type="text" name="calendar[end][{{$loop->index}}]" class="form-control timepicker" data-time="{{$configs->end_hours[$loop->index]}}">
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    </div>
</form>
