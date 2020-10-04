@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Médicos</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        <div class="appointment-message">Le informamos que si usted va solicitar un turno para un menor de 2 meses debe comunicarse con el centro en los días y horarios de atención para priorizar su turno. <p>Muchas gracias, Centro de Cardiología Infantil Santa Fe.</p></div>

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('patient_section.professionals.table')
            </div>
        </div>
    </div>
@endsection

