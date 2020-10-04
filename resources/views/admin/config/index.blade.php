@extends('layouts.app')

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
                <i class="fa fa-check"></i> Profesionales</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane {{ ($active_tab == 0) ? 'active' : '' }}" id="tab_1">
                @include('admin.config.general')
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane {{ ($active_tab == 1) ? 'active' : '' }}" id="tab_2">
                @include('admin.config.professional')
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>

    </section>
@endsection