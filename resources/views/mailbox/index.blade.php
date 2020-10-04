@extends('layouts.app')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Casilla de emails
        <small>Desde aquí puedes enviar emails a los pacientes</small>
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
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="clearfix"></div>

          @include('flash::message')

          <div class="clearfix"></div>
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Enviados</h3>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body no-header">
              @include('mailbox.table')
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
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