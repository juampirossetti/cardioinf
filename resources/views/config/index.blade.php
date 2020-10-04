@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ URL::asset('css/wickedpicker.min.css') }}">
@endpush

@section('content')
    <section class="content-header">
        <h1>Configuración</h1>
    </section>
    <section class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="{{ ($active_tab == 0) ? 'active' : '' }}"><a href="#tab_1" data-toggle="tab" aria-expanded="true">
                <i class="fa fa-wrench"></i> General</a></li>
              <li class="{{ ($active_tab == 1) ? 'active' : '' }}"><a href="#tab_2" data-toggle="tab" aria-expanded="false">
                <i class="fa fa-calendar"></i> Calendario</a></li>
              <li class="{{ ($active_tab == 2) ? 'active' : '' }}"><a href="#tab_3" data-toggle="tab" aria-expanded="false">
                <i class="fa fa-user"></i> Pacientes</a></li>
              <li class="{{ ($active_tab == 3) ? 'active' : '' }}"><a href="#tab_4" data-toggle="tab" aria-expanded="false">
                <i class="fa fa-check"></i> Turnos</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane {{ ($active_tab == 0) ? 'active' : '' }}" id="tab_1">
                @include('config.general')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane {{ ($active_tab == 1) ? 'active' : '' }}" id="tab_2">
                @include('config.calendar')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane {{ ($active_tab == 2) ? 'active' : '' }}" id="tab_3">
                @include('config.patient')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane {{ ($active_tab == 3) ? 'active' : '' }}" id="tab_4">
                @include('config.appointment')
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>

    </section>
@endsection


@push('javascript')
    <script type="text/javascript" src="{{ URL::asset('js/wickedpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/configuration.js') }}?v={{ config('app.version') }}"></script>
@endpush