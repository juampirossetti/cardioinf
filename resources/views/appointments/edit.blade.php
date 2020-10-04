@extends('layouts.app')

@section('css')
     @include('layouts.datetime.datetime_css')
     @include('appointments.includes.appointments_css')
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Turno
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($appointment, ['route' => ['appointments.update', $appointment->id], 'method' => 'patch']) !!}
                        {{ Form::hidden('_id', $appointment->id) }}
                        @include('appointments.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
    @include('layouts.datetime.datetime_js')
    @include('appointments.includes.appointments_js')
@endsection