@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Editar Obra Social del paciente
        </h1>
   </section>
   <div class="content">
       @include('adminlte-templates::common.errors')

       @include('flash::message')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                  {!! Form::model($patientInsurance, ['route' => ['patients.insurances.update', $patientInsurance->patient->id, $patientInsurance->id], 'method' => 'patch']) !!}

                        @include('patients.insurances.fields')

                   {!! Form::close() !!} 
               </div>
           </div>
       </div>
   </div>
@endsection