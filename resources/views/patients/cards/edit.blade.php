@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar ficha del paciente
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')

       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                  {!! Form::model($card, ['route' => ['patients.cards.update', $card->patient->id, $card->id], 'method' => 'patch']) !!}

                        @include('patients.cards.fields')

                   {!! Form::close() !!} 
               </div>
           </div>
       </div>
   </div>
@endsection