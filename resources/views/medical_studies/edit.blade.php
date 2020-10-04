@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Estudio Médico
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($medicalStudy, ['route' => ['medicalStudies.update', $medicalStudy->id], 'method' => 'patch']) !!}
                        
                        {{ Form::hidden('_id', $medicalStudy->id) }}
                        @include('medical_studies.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection