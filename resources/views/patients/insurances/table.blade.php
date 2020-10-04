<h3 class="pull-left">
	Obras sociales
    <a class="btn btn-primary pull-right" style="margin-top: -5px;margin-bottom: 5px; margin-left:5px;" href="{!! route('patients.insurances.create', [$patient->id]) !!}">Agregar Otra</a>
</h3>
<!-- DataTable -->
{!! $dataTable->table(['width' => '100%']) !!}

@push('patient-scripts')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush