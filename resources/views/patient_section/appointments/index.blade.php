@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Sus turnos</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right btn-flat" id="newAppointment" style="margin-top: -10px;margin-bottom: 5px" href="#">Solicitar Turno</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('patient_section.appointments.table')
            </div>
        </div>
    </div>
    @include('patient_section.appointments.newAppointmentModal')
    @include('patient_section.appointments.insuranceInformation')
@endsection