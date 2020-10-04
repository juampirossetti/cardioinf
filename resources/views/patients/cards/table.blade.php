<h3 class="pull-left">
	Fichas
	<a class="btn btn-primary pull-right" style="margin-top: -5px;margin-bottom: 5px; margin-left:5px;" href="{!! route('patients.cards.create', [$patient->id]) !!}">Agregar Otra</a>
</h3>
<table class="table no-footer dtr-inline" id="cards-table">
    <thead>
        <tr>
          	<th>Id</th>
            <th>Profesional</th>
            <th>Número</th>
            <th>Acción</th>
        </tr>
    </thead>
</table>


{!! Form::open(['route' => 'patients.index', 'method' => 'delete', 'id' => 'deleteForm']) !!}
{!! Form::close() !!}

{!! Form::hidden('patient_id', $patient->id) !!}

@push('patient-scripts')
	<script>
  		var url = {!! json_encode(route('patients.cards.data')) !!};
	</script>
	<script type="text/javascript" src="{{ URL::asset('js/secretary/patient.show.js') }}?v={{ config('app.version') }}"></script>
@endpush

