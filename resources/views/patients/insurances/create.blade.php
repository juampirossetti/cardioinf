@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Nueva obra social del paciente
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => ['patients.insurances.store', $patient->id]]) !!}

                        @include('patients.insurances.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection