@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            Nueva historia clínica
        </h1>
    </section>
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'historias.store']) !!}

                        @include('patients_histories.fields')
                        
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Crear', ['class' => 'btn btn-primary']) !!}
                            <a href="{!! route('historias.index') !!}" class="btn btn-default">Cancelar</a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script> 
    <script>localStorage.setItem('api_token','{!! $user->api_token !!}');</script>
    <script>
      var history_d = null;
    </script>
    <script type="text/javascript" src="{{ URL::asset('js/professional/historias.create.js') }}?v={{ config('app.version') }}"></script>
@endsection