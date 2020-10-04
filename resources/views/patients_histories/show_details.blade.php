
{!! Form::open(['route' => 'detalleHistoria.store', 'id' => 'detailForm', 'enctype' => 'multipart/form-data', 'onSubmit' => 'return formValidation();']) !!}
<ul class="timeline">
    @if (Auth::user()->hasRole(['professional']))
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-blue">
            Nueva nota
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li>
        @include('patients_histories.newHistoryDetail')
    </li>
    @endif

@foreach ($history->details as $detail)
    <!-- timeline time label -->
    <li class="time-label">
        <span class="bg-blue detail-date" data-date="{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->date)->format('d-m-Y')}}">
            {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->date)->format('d-m-Y')}}
        </span>
    </li>
    <!-- /.timeline-label -->

    <!-- timeline item -->
    <li class="detail-description">
        <!-- timeline icon -->
        <i class="fa fa-user bg-aqua"></i>
        <div class="timeline-item" data-detailid="{{$detail->id}}">
            <span class="time detail-time" data-time="{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->date)->format('H:i')}}"><i class="fa fa-clock-o"></i> 
                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->date)->format('H:i')}}
            </span>
            
            <h3 class="timeline-header"><a href="#">Nota del profesional</a></h3>

            <div class="timeline-body">
                <span class="detail-description-span">{{$detail->description}}</span>
                @if(count($detail->files))
                <h5>Archivos adjuntos</h5>
                <ul>
                    @foreach($detail->files as $file)
                    <li>
                        <span class="detail-file" data-id="{{$file->id}}" data-name="{{$file->name}}">{{$file->name}}</span>
                        <a href="#" class="file-link file-show-link" data-hid="{{$history->id}}" data-iid="{{$file->id}}" data-url="{{url('/image/show/'.$history->id.'/'.$file->id) }}"><i class="fa fa-eye"></i> Ver</a>
                        <a href="{{url('/image/download/'.$history->id.'/'.$file->id.'/'.$file->name) }}" class="file-link file-download-link" data-hid="{{$history->id}}" data-iid="{{$file->id}}" download><i class="fa fa-download"></i> Descargar</a>
                    </li>
                    @endforeach
                </ul>
                @endif
            </div>
            @if (Auth::user()->hasRole(['professional']))
            <div class="timeline-footer">
                <a class="btn btn-primary btn-xs btn-edit">Editar</a>
                <a class="btn btn-danger btn-xs btn-delete-detail" data-id="{{$detail->id}}">Eliminar</a>
            </div>
            @endif
        </div>
    </li>
@endforeach
    <li class="time-label">
        <span class="bg-blue">
            Fin de registros
        </span>
    </li>
</ul>

{!! Form::close() !!}