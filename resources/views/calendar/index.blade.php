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
                    <div class="form-group">
                        {!! Form::label('professional', 'Profesional') !!}
                        {{ Form::select('professional', $professionals, null, ['class' => 'form-control', 'id' =>   'professional'])}}
                    
                    </div>

                    <div class="form-group">
                        {!! Form::label('medical_study', 'Tipo de consulta') !!}
                        {{ Form::select('medical_study', array('null' => 'Todas') + $medicalStudies,
                            null, 
                            ['class' => 'form-control', 'id' =>   'medical_study'])}}
                    
                    </div>

                    <!-- Date Field -->
                    <div class="cargando-fechas">Cargando Fechas...</div>
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
                    <div class="col-xs-12">
                        <p class="pull-right calendar-totals"><strong>Cupones: </strong><span id="total-coupons"></span></p>
                        <p class="pull-right calendar-totals"><strong>Dinero: </strong><span id="total-money"></span></p>
                    </div>
                    <div class="col-xs-12" id="addedButtons">
                    </div>
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
        </div>

    </div>

@include('calendar.newAppointmentsModal')

@include('calendar.editAppointmentModal')

@include('calendar.newUniqueAppointmentModal')

@include('calendar.newWeekAppointmentsModal')

@include('calendar.newPatientForm')

@include('calendar.modal.delete')

@include('calendar.modal.rangePickerModal')

@endsection


@section('scripts')
    @include('layouts.datetime.datetime_js')
    @include('calendar.includes.calendar_js')
@endsection