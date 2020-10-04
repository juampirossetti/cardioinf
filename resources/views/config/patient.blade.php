<form action="{{ route('system.update','patient') }}" method="POST">
    <div class="row">
        <!-- general form elements disabled -->
        {{ csrf_field() }}
        
        <div class="col-md-6">
            <!-- text input -->
            <div class="form-group">
                <label>Creación de usuarios desde pantalla de Inicio
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Permite que un usuario se registre. De modo contrario sólo la secretaria puede crear usuarios."></span>
                </label>
                {!! Form::select('user_from_login', array('0' => 'NO', '1' => 'SI'), 
                                  $configs->user_from_login,
                                  ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Enviar recordatorio
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Se le enviará una notificación al email del paciente para recordarle el turno."></span>
                </label>
                {!! Form::select('send_reminder', 
                                  array('24' => '24 hs. antes',  
                                        '48' => '48 hs. antes',
                                        '72' => '72 hs. antes',
                                        '0' => 'Nunca'), 
                                  $configs->send_reminder,
                                  ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>