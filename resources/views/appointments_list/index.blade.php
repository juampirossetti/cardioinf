@extends('layouts.app')

@section('css')
    @include('layouts.datatables_css')
@endsection

@section('content')
    <section class="content-header">
        <h1>Buscar Turnos por paciente </h1>
    </section>
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                    @include('appointments_list.search')
                    @include('appointments_list.table')
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.datatables_js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script> 
    <script>localStorage.setItem('api_token','{!! $user->api_token !!}');</script>
    <script type="text/javascript" src="{{ URL::asset('js/secretary/appointments.search.js') }}?v={{ config('app.version') }}"></script>
@endsection