@extends('layouts.app')

@section('css')
     @include('layouts.datetime.datetime_css')
     @include('timetables.includes.timetables_css')
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Horario
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'timetables.store', 'id' => 'timetable-form']) !!}

                        @include('timetables.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @include('layouts.datetime.datetime_js')
    @include('timetables.includes.timetables_js')
@endsection
