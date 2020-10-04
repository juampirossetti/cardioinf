      <div class="row mobile" style="display:none;">
        <div class="col-lg-12">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">2. Seleccione un día y horario  </h3><h6 class="form-text text-muted">Utilice las flechas a los laterales para navegar.</h6>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="unselect-professional carousel-msg" id="patient-carousel-msg">Primero debe seleccionar un tipo de consulta y una obra social</div>
              <div class="loading carousel-msg" id="patient-loading-msg" style="display:none;">Cargando turnos...</div>
              <div class="appointment-unaivalable carousel-msg" id="patient-error-msg" style="display:none;">El turno seleccionado fue recientemente otorgado. Se recargaron los turnos disponible. Por favor seleccione uno. </div>
              <div class="appointment-selected carousel-msg" id="patient-success-msg" style="display:none;">Turno correctamente seleccionado</div>
              <div id="mobile-carouselshow" class="carousel slide carousel-msg appointments-carousel" data-ride="mobile-carousel" data-interval="false" style="display:none;">
                <div class="carousel-inner">
                <!-- /. slide -->
                @for ($i = 0; $i < 60; $i++)
                  @if($i == 0)
                    <div class="item active">
                  @else
                    <div class="item">
                  @endif
                    <div class="time-container col-md-10 col-md-offset-1">
                      <div class="col-md-12 day-item">
                      <p class="title">Title</p>
                        <input type="hidden" class="date-value" value="day">
                        <button type="button" class="btn grey no-margin control control-up" data-id="0"><i class="fa fa-chevron-up"></i></button>
                        <ul class="scrollable-menu hour-list" role="menu"></ul>
                        <button type="button" class="btn grey no-margin control control-down" data-id="0"><i class="fa fa-chevron-down"></i></button>
                      </div>                      
                      <div class="col-md-12">
                        <button type="button" class="btn grey control select-date datepicker" data-id="0"><i class="fa fa-calendar"></i>&nbsp SELECCIONAR OTRO DÍA </button>
                      </div>
                    </div>
                  </div>
                <!-- ./ slide -->
                @endfor
                </div>
                <a class="left carousel-control" href="#mobile-carouselshow" data-slide="prev">
                  <span class="fa fa-angle-left"></span>
                </a>
                <a class="right carousel-control" href="#mobile-carouselshow" data-slide="next">
                  <span class="fa fa-angle-right"></span>
                </a>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>