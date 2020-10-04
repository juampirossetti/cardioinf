@extends('layouts.app')

@section('css')
    @include('layouts.datetime.datetime_css')
    <script type="text/javascript" src="{{ URL::asset('js/professional/historias.validation.js') }}?v={{ config('app.version') }}"></script>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Historia Clínica
        </h1>
    </section>
    <div class="content">
    <div class="clearfix"></div>
    @include('flash::message')
    <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('patients_histories.show_fields')
                    <div class="col-sm-12">
                        <a href="{!! route('historias.index') !!}" class="btn btn-default">Listado de Historias</a>

                        <a href="{!! route('historias.edit',['id' => $history->id]) !!}" class="btn btn-primary">Editar</a>
                    </div>
                </div>
            </div>
        </div>
            @include('patients_histories.show_details')
            @include('patients_histories.modal.success')
            @include('patients_histories.modal.error')
            @include('patients_histories.modal.edit')
            @include('patients_histories.modal.image')
    </div >
@endsection

@section('scripts')
    @include('patients_histories.includes.history_js')
    @include('layouts.datetime.datetime_js')
@endsection