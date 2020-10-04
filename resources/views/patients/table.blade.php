@section('css')
    @include('layouts.datatables_css')
@endsection

<!-- Start Search Box -->
{!! Form::open(['route' => 'patients.index', 'id' => 'search-patient-form', 'method' => 'GET']) !!}
    <div class="form-group form-inline">
        <label>Buscar: </label>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
        {!! Form::text('surname', null, ['class' => 'form-control', 'placeholder' => 'Apellido']) !!}
        {!! Form::text('dni', null, ['class' => 'form-control', 'placeholder' => 'Documento']) !!}
        {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
        {!! Form::button('Ver Todos', ['class' => 'btn btn-warning', 'id' => 'search-view-all']) !!}
    </div>
{!! Form::close() !!}
<!-- End search Box -->
{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function(){
            $('#search-view-all').on('click', function(){
                $('input[name="name"]').val("");
                $('input[name="surname"]').val("");
                $('input[name="dni"]').val("");
                $('#search-patient-form').submit();
            })
        });
    </script>
@endsection