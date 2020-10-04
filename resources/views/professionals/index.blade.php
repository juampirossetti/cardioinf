@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Médicos</h1>
        @if(SMConfig::getByKey('max_number_of_professionals') > count(Professional::all()))
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" id="add-professional" style="margin-top: -5px;margin-bottom: 5px" href="{!! route('professionals.create') !!}">Agregar Nuevo</a>
        </h1>
        @endif
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
        <div class="box-body">
                    @include('professionals.table')
            </div>
        </div>
    </div>
@endsection
