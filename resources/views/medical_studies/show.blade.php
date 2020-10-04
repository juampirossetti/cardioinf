@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Medical Study
        </h1>
    </section>
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    @include('medical_studies.show_fields')
                    <a href="{!! route('medicalStudies.index') !!}" class="btn btn-default">Volver</a>
                </div>
            </div>
        </div>
    </div>
@endsection
