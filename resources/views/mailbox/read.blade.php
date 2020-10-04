@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Leer Mail
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-3">
          <a href="{!! route('mailbox.create') !!}" class="btn btn-primary btn-block margin-bottom">Nuevo Email</a>

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
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Leer Email</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3>{{$email->subject}}</h3>
                <h5>Para: {{$email->to}}
                  <span class="mailbox-read-time pull-right">{{ \Carbon\Carbon::parse($email->sended_date)->format('d-m-Y H:i')}}</span></h5>
              </div>
              <!-- /.mailbox-read-info -->
              <div class="mailbox-read-message">
                {!! $email->content !!}
              </div>
              <!-- /.mailbox-read-message -->
            </div>
            <!-- /.box-body -->
            <!-- /.box-footer -->
            <div class="box-footer">
              {!! Form::open(['route' => ['mailbox.destroy', $email->id], 'method' => 'delete']) !!}
              <!-- <button type="button" class="btn btn-default"><i class="fa fa-trash-o"></i> Borrar</button> -->
              
              {!! Form::button('<i class="fa fa-trash-o"></i> Borrar', [
                'type' => 'submit',
                'class' => 'btn btn-default',
                'onclick' => "return confirm('¿Esta seguro que desea eliminar este registro?')"
              ]) !!}
              {!! Form::close() !!}
              
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  
@endsection