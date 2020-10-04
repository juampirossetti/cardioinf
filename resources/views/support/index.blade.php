@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-6 col-md-offset-3">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-question-circle"></i>

              <h3 class="box-title">Preguntas Frecuentes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <p class="support-faq"><a href="http://docs.misturnosonline.com/docs/paciente/solicitar-un-turno/" target="_blank">¿Cómo solicitar un turno?</a></p>
              
              <p class="support-faq"><a href="http://docs.misturnosonline.com/docs/paciente/consultar-cancelar-un-turno/" target="_blank">¿Cómo consultar o cancelar un turno?</p>
              
              <p class="support-faq"><a href="http://docs.misturnosonline.com/docs/paciente/cambiar-la-informacion-de-mi-perfil/" target="_blank">¿Cómo cambiar mi información de perfil?</p>
              
              <p class="support-faq"><a href="http://docs.misturnosonline.com/docs/paciente/cambiar-mi-email-o-contrasena/" target="_blank">¿Cómo cambiar mi email o contraseña?</p>

              <div class="text-center">
                <a href="http://docs.misturnosonline.com" target="_blank">
                  <button class="btn btn-success btn-md">Ver Documentación</button>
                </a>
              </div>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- ./col -->
      </div>
</div>
      @endsection
