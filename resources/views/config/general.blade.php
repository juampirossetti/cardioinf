{!!Form::open(['url' => route('system.update','general'), 'method' => 'post', 'files' => true]) !!}
    <div class="row">
    <!-- general form elements disabled -->
    {{ csrf_field() }}
    
    <div class="col-md-6">
        <!-- text input -->
        <div class="form-group">
            <label>Nombre de la institución</label>
            <input type="text" class="form-control" placeholder="Lara" name="sitename" value="{{$configs->sitename}}">
        </div>
        <div class="form-group">
            <label>Primera palabra del nombre
                <span class="glyphicon glyphicon-question-sign tooltips" data-toggle="tooltip" data-placement="top" title="" data-original-title="Esta opción sirve para mostrar el nombre en la parte superior izquierda del sistema."></span>
            </label>
            <input type="text" class="form-control" placeholder="Lara" name="sitename_part1" value="{{$configs->sitename_part1}}">
        </div>
        <div class="form-group">
            <label>Segunda palabra del nombre</label>
            <input type="text" class="form-control" placeholder="Admin 1.0" name="sitename_part2" value="{{$configs->sitename_part2}}">
        </div>

        <div class="form-group">
            <label>Logo de la pantalla de inicio</label>   
            {!! Form::file('logo', array('class' => 'form-control')) !!}
            <p class="form-text text-muted" style="font-size: 14px;">
                Tamaño recomendado: 640x140 pixeles.
            </p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Siglas del sitio (2/3 Characters)</label>
            <input type="text" class="form-control" placeholder="LA" maxlength="2" name="sitename_short" value="{{$configs->sitename_short}}">
        </div>
        <div class="form-group">
            <label>Descripción del sitio</label>
            <input type="text" class="form-control" placeholder="Descripción en 140 caracteres" maxlength="140" name="site_description" value="{{$configs->site_description}}">
        </div>
    </div>
    <div class="col-md-12">
        <button type="submit" class="btn btn-primary">Guardar</button>
    </div>
    </div>
{!! Form::close() !!}