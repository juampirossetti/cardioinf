      <div class="row">
        <div class="col-md-8">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">2. Seleccione un día y horario</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="unselect-professional carousel-msg" id="patient-carousel-msg">Primero debe seleccionar un tipo de consulta </div>
              <div class="loading carousel-msg" id="patient-loading-msg" style="display:none;">Cargando turnos...</div>
              <div id="carousel-example-generic" class="carousel slide carousel-msg appointments-carousel" data-ride="carousel" data-interval="false" style="display:none;">
                <div class="carousel-inner">
                <!-- /. slide -->
                @foreach ($appointments as $slide) 
                  @if($loop->index == 0)
                    <div class="item active">
                  @else
                    <div class="item">
                  @endif
                    <div class="time-container col-md-10 col-md-offset-1">
                    @foreach($slide as $day=>$appointment_list)
                      <div class="col-md-4">
                      <p class="title">{{ucwords(Carbon\Carbon::parse($day)->formatLocalized('%A %d de %B'))}}</p>
                        <input type="hidden" class="date-value" value="{{$day}}">
                        <button type="button" class="btn grey no-margin control control-up" data-id="0"><i class="fa fa-chevron-up"></i></button>
                        <ul class="scrollable-menu hour-list" role="menu">
                        @if($appointment_list[0]->id != '')
                          @foreach($appointment_list as $single)
                            <li><a href="javascript:void(0);">{{$single->time}}</a></li>
                          @endforeach
                        @else
                          <div class="no-appointments">
                            Ningún turno disponible para este día
                          </div>
                        @endif
                        </ul>
                        <button type="button" class="btn grey no-margin control control-down" data-id="0"><i class="fa fa-chevron-down"></i></button>
                      </div>
                      @endforeach
                      <div class="col-md-12">
                        <button type="button" class="btn grey control select-date" data-id="0"><i class="fa fa-calendar"></i>&nbsp SELECCIONAR OTRO DÍA </button>
                      </div>
                    </div>
                  </div>
                @endforeach
                <!-- ./ slide -->
                </div>
                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>