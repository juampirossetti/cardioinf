@extends('layouts.app')

@role('secretary')
    @section('css')
        <link rel="stylesheet" href="{{ URL::asset('css/secretary.css') }}?v={{ config('app.version') }}">
    @endsection
@endrole

@section('content')
    <section class="content-header">
        <h1 class="pull-left">Datos de su cuenta</h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')
        @include('adminlte-templates::common.errors')
        
        <div class="clearfix"></div>
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'account.update']) !!}

                        @include('account.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection