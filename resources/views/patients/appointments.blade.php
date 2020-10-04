<h3>
    Turnos pasados
</h3>

<table id="history-table" class="table table-bordered table-hover" style="max-width: 720px;">
    <thead>
        <tr>
            <th style="width: 120px;">Fecha</th>
            <th>Profesional</th> 
            <th style="width: 260px;">Tipo de Consulta</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patient->appointments as $appointment)
        <tr>
            <td style="width: 120px;">{{Carbon\Carbon::parse($appointment->date)->format('d-m-Y') }}</td>
            <td>{{$appointment->professional_id}}</td> 
            <td style="width: 260px;">{{ isset($appointment->medicalStudy) ? $appointment->medicalStudy->name : 'No especifica'}}</td>
        </tr>
        @endforeach
    </tbody>
 </table>