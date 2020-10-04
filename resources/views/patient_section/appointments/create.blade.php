@extends('layouts.app')

@section('css')
  <link rel="stylesheet" href="{{ URL::asset('css/patient/create.appointment.css') }}?v={{ config('app.version') }}">
  @include('layouts.datetime.datetime_css')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Solicitar Turno
        </h1>
    </section>

    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="row">
        <div class="col-lg-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-user-md"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Profesional</span>
              <span class="info-box-number">{{$professional->complete_name}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <div class="callout callout-warning">
            <h4>Tiempo disponible para pedir el turno: <span class="time" id="timer">10:00<span></h4>
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        
      </div>
      @include('patient_section.appointments.insurance_select')
      @include('patient_section.appointments.timecarousel')
      @include('patient_section.appointments.timecarousel_mobile')
      @include('patient_section.appointments.confirm')
      @include('patient_section.appointments.fields')
    </div>
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ URL::asset('js/patient/create.appointment.js') }}?v={{ config('app.version') }}"></script>
  <script>
    localStorage.setItem('api_token','{!! $user->api_token !!}');
  </script>
  @include('layouts.datetime.datetime_js')
@endsection
