@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Historia Clínica
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('histories.show_fields')
                    <a href="{!! URL::previous() !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
            @include('histories.show_details')
    </div >
@endsection

@section('scripts')
    @include('histories.includes.history_js')
@endsection