@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Indicaciones para pacientes
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($indication, ['route' => ['indications.update', $indication->id], 'method' => 'patch']) !!}
                   
                        {{ Form::hidden('_id', $indication->id) }}
                        @include('indications.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection