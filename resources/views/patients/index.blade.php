@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Pacientes</h1>
        @role('secretary')
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -5px;margin-bottom: 5px" href="{!! route('patients.create') !!}">Agregar Nuevo</a>
        </h1>
        @endrole
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('patients.table')
            </div>
        </div>
    </div>
@endsection

