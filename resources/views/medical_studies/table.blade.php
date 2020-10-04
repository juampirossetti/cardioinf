@section('css')
    @include('layouts.datatables_css')
@endsection

<!-- Start Search Box -->
{!! Form::open(['route' => 'medicalStudies.index', 'id' => 'search-ms-form', 'method' => 'GET']) !!}
    <div class="form-group form-inline">
        <label>Buscar: </label>
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Nombre']) !!}
        {!! Form::submit('Buscar', ['class' => 'btn btn-primary']) !!}
        {!! Form::button('Ver Todos', ['class' => 'btn btn-warning', 'id' => 'search-view-all']) !!}
    </div>
{!! Form::close() !!}
{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    <script>
        $(document).ready(function(){
            $('#search-view-all').on('click', function(){
                $('input[name="name"]').val("");
                $('#search-ms-form').submit();
            })
        });
    </script>
@endsection