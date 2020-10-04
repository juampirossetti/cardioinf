<ul class="timeline">

@for ($i = 0; $i < 2; $i++)
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-blue">
            {{$i+10}} Feb. 2014
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <!-- timeline icon -->
        <i class="fa fa-user bg-aqua"></i>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

            <h3 class="timeline-header"><a href="#">Notas del profesional</a></h3>

            <div class="timeline-body">
                Content goes here

            </div>

            <div class="timeline-footer">
                <a class="btn btn-primary btn-xs btn-edit">Editar</a>
                <a class="btn btn-primary btn-xs btn-save" style="display:none;">Guardar</a>
                <a class="btn btn-danger btn-xs btn-delete">Eliminar</a>
                <a class="btn btn-danger btn-xs btn-cancel" style="display:none;">Cancelar</a>
            </div>
        </div>
    </li>
@endfor
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-blue">
            7 Jun. 2017
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        <div class="timeline-item">
            <span class="time"><i class="fa fa-clock-o"></i> 12:05</span>

            <h3 class="timeline-header"><a href="#">Notas del profesional</a></h3>

            <div class="timeline-body">
               <textarea class="form-control" rows="5" id="comment"></textarea>
            </div>

            <div class="timeline-footer">
                <a class="btn btn-primary btn-xs">Guardar</a>
            </div>
        </div>
    </li>

    <!-- timeline time label -->
    <li class="time-label">
        <!-- timeline icon -->
        <i class="fa fa-plus bg-blue"></i>
    </li>
</ul>