@extends('layouts.app')

@section('css')
     @include('layouts.datetime.datetime_css')
     @include('exceptions_days.includes.exceptions_css')
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Excepción de estudios para un día particular
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($exceptionDay, ['route' => ['exceptionsdays.update', $exceptionDay->id], 'method' => 'patch']) !!}
                        {{ Form::hidden('_id', $exceptionDay->id) }}
                        @include('exceptions_days.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
    @include('layouts.datetime.datetime_js')
    @include('exceptions_days.includes.exceptions_js')
@endsection