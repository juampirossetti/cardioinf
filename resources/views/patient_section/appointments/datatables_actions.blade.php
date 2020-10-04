<div class="dropdown pull-right">
    <div class="btn-group">
        <button type="button" class="btn dropdown-toggle btn-default btn-sm" data-toggle="dropdown" aria-expanded="false">Links <span class="caret"></span></button>
            <ul class="dropdown-menu pull-right">
            @if(Carbon\Carbon::createFromFormat('Y-m-d',$date) >= Carbon\Carbon::now())
            <li>
                {!! Form::open(['route' => ['patient.appointments.destroy', $id], 'method' => 'delete', 'class' => 'delete-form']) !!}
                {!! Form::close() !!}
                <a href="#" class="delete-link">Cancelar Turno</a>
            </li>
            @endif
            <li><a href="#" class="insurance-information-link" data-ms-id="{{$medical_study_id}}" data-in-id="{{$insurance_id}}" data-ms-name="{{$medical_study_name}}" data-in-name="{{$insurance_name}}">Documentación</a></li>
                    
            <li><a href="{{route('voucher.print',['appointment' => $id])}}" data-id={{$id}} class="voucher-link">Imprimir Comprobante</a></li>
        </ul>
    </div>
</div>

