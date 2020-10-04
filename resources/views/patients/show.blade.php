@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('css/histories.css') }}?v={{ config('app.version') }}">
    @include('layouts.datatables_css')
@endsection
@section('content')
    <section class="content-header">
        <h1>
            Paciente
        </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        <div class="clearfix"></div>
        
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('patients.show_fields')
                    <a href="{!! route('patients.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @stack('patient-scripts')
@endsection

