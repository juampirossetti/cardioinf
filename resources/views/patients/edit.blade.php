@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Paciente
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($patient, ['route' => ['patients.update', $patient->id], 'method' => 'patch']) !!}

                        {{ Form::hidden('_id', $patient->id) }}
                        @include('patients.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ URL::asset('js/edit.patient.js') }}?v={{ config('app.version') }}"></script>
  <script>
    localStorage.setItem('api_token','{!! $user->api_token !!}');
  </script>
@endsection