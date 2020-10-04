@extends('layouts.app')

@section('css')
    @include('layouts.datetime.datetime_css')
    @include('calendar.includes.calendar_css')
@endsection

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Calendario</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        <div class="flash-message">
        </div>
        @include('flash::message')
        <div class="clearfix"></div>
        
        <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <div class="box-body">
                    
                    <!-- Date Field -->
                    <div class="form-group hidden-sm hidden-xs calendar-form" style="display:none;">
                        <div class="col-md-12 row">
                            {!! Form::label('calendar_date', 'Fecha') !!}
                        </div>
                        {!! Form::text('calendar_date', 
                            null, 
                            ['class' => 'form-control datepicker read-only calendar-date', 'readonly' => 'readonly']) !!}
                    </div>

                    <div class="hidden-sm hidden-xs">
                        {!! Form::label('legend', 'Leyendas') !!}
                    </div>
                    <div class="col-md-12 hidden-sm hidden-xs">
                        @include('calendar.legend')
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-body">
                    <div class="col-xs-12" id="addedButtons">
                    </div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
        </div>

    </div>

@include('professional_section.calendar.modal.editAppointmentModal')

@endsection

@section('scripts')
    <script>
        var prof_name = {!! json_encode($user->name) !!};
        var prof_id = {!! json_encode($user->professional->id) !!};
    </script>
    @include('layouts.datetime.datetime_js')
    @include('professional_section.calendar.includes.calendar_js')
@endsection