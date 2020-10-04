@section('css')
    @include('layouts.datatables_css')
@endsection
<h3 class="pull-left">Excepciones de Obras Sociales</h3>
<!-- DataTable -->
{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endsection