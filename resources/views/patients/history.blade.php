<h3>
    Historias Clínicas
</h3>

<table id="history-table" class="table table-bordered table-hover" style="max-width: 720px;">
    <thead>
        <tr>
            <th style="width: 60px;">#</th>
            <th>Profesional</th> 
            <th style="width: 80px;">Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach($patient->histories as $history)
        <tr>
            <td style="width: 60px;">{{$history->id}}.</td>
            <td>{{$history->professional->getCompleteName()}}</td> 
            <td style="width: 80px;">
                @include('patients.histories_actions')
            </td>
        </tr>
        @endforeach
    </tbody>
 </table>

 @include('patients.newHistory')