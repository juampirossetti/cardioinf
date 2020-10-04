@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Médico
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')

       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($professional, ['route' => ['professionals.update', $professional->id], 'method' => 'patch']) !!}
                        {{ Form::hidden('_id', $professional->id) }}
                        @include('professionals.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection

@section('scripts')
  <script type="text/javascript" src="{{ URL::asset('js/edit.professional.js') }}?v={{ config('app.version') }}"></script>
  <script>
    localStorage.setItem('api_token','{!! $user->api_token !!}');
  </script>
@endsection