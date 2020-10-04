@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('vendor/bootstrap3-wysihtml5/bootstrap3-wysihtml5.min.css') }}">
@endsection

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Casilla de emails
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="{!! route('mailbox.index') !!}" class="btn btn-primary btn-block margin-bottom">Volver a la bandeja de entrada</a>

          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Carpetas</h3>

              <div class="box-tools">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="box-body no-padding">
              <ul class="nav nav-pills nav-stacked">
                <li><a href="{!! route('mailbox.index') !!}"><i class="fa fa-envelope-o"></i> Enviados</a></li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /. box -->
        </div>

        <!-- /.col -->
        <div class="col-md-9">
          {!! Form::open(['route' => 'mailbox.sendemail']) !!}
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Nuevo Email</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              @include('adminlte-templates::common.errors')
              @include('flash::message')
              <div class="form-group">
                {!! Form::text('to', isset($to) ? $to : null, ['class' => 'form-control', 'placeholder' => 'Para:']) !!}
              </div>
              <div class="form-group">
                {!! Form::text('subject', null, ['class' => 'form-control', 'placeholder' => 'Asunto:', 'maxlength' => '128']) !!}
              </div>
              <div class="form-group">
                {{ Form::textarea('content', null, ['class' => 'form-control', 'id' => 'compose-textarea', 'style' => 'height: 300px;']) }}
                    </textarea>
              </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer">
              <div class="pull-right">
                <button type="submit" class="btn btn-primary"><i class="fa fa-envelope-o"></i> Enviar</button>
              </div>
              <a  href="{!! route('mailbox.index') !!}" ><button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Descartar</button></a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
          {!! Form::close() !!}
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  @endsection

  
  @section('scripts')
    <script type="text/javascript" src="{{ URL::asset('vendor/bootstrap3-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('vendor/bootstrap3-wysihtml5/locales/bootstrap-wysihtml5.es-AR.js') }}"></script>
    <script type="text/javascript">
      $('#compose-textarea').wysihtml5({
        toolbar: {
          "font-styles": true, //Font styling, e.g. h1, h2, etc. Default true
          "emphasis": true, //Italics, bold, etc. Default true
          "lists": true, //(Un)ordered lists, e.g. Bullets, Numbers. Default true
          "html": false, //Button which allows you to edit the generated HTML. Default false
          "link": false, //Button to insert a link. Default true
          "image": false, //Button to insert an image. Default true,
          "color": false, //Button to change color of font  
          "blockquote": false, //Blockquote 
        },
        locale: "es-AR"
      });
    </script>
  @endsection