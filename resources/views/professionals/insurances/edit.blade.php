@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Excepción de Obra Social
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')

       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                  {!! Form::model($insuranceException, ['route' => ['professionals.insurances.update', $insuranceException->professional->id, $insuranceException->id], 'method' => 'patch']) !!}

                        @include('professionals.insurances.fields')

                   {!! Form::close() !!} 
               </div>
           </div>
       </div>
   </div>
@endsection