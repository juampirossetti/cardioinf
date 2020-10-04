@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Obra Social
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('insurances.show_fields')
                    <a href="{!! route('insurances.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
