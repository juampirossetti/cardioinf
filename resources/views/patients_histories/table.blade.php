@section('css')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%']) !!}

@section('scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}

    <script type="text/javascript">
        var search = {!! json_encode($search) !!}
    </script> 

    <script type="text/javascript" src="{{ URL::asset('js/professional/historias.index.js') }}?v={{ config('app.version') }}"></script>
@endsection