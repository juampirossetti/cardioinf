<form action="{{ route('admin.system.update','professional') }}" method="POST">
    <div class="row">
        <!-- general form elements disabled -->
        {{ csrf_field() }}
        
        <div class="col-md-6">
            <!-- text input -->
            <div class="form-group">
                <label>Profesionales
                    <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Habilita la sección de profesionales en el sistema."></span>
                </label>
                {!! Form::select('professional_section_enabled', array('0' => 'NO', '1' => 'SI'), 
                                  $configs->professional_section_enabled,
                                  ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <!-- text input -->
            <div class="form-group">
                <label>Número máximo de profesionales</label>
                <input type="text" class="form-control" placeholder="Lara" name="max_number_of_professionals" value="{{$configs->max_number_of_professionals}}">
            </div>
        </div>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
    </div>
</form>