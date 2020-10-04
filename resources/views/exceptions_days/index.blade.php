@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Excepciones de Estudios médicos</h1>
        <h1 class="pull-right">
           <a class="btn btn-primary pull-right" style="margin-top: -5px;margin-bottom: 5px" href="{!! route('exceptionsdays.create') !!}">Agregar Nueva</a>
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('exceptions_days.table')
            </div>
        </div>
    </div>
@endsection