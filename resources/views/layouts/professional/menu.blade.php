<li class="header"> MENÚ DE PROFESIONAL</li>

<li class="{{ Request::is('professional/calendar*') ? 'active' : '' }}">
    <a href="{!! route('professional.calendar') !!}"><i class="fa fa-calendar"></i><span> Calendario</span></a>
</li>

@if(Auth::user()->professional->id != 2)
<li class="{{ Request::is('management/patients*') ? 'active' : '' }}">
    <a href="{!! route('patients.index') !!}"><i class="fa fa-users"></i><span> Pacientes</span></a>
</li>
<li class="{{ Request::is('management/historias*') ? 'active' : '' }}">
    <a href="{!! route('historias.index') !!}"><i class="fa fa-star"></i><span> Historias Clínicas</span></a>
</li>
@endif

<li class="header"> MIS DATOS</li>

<li class="{{ Request::is('account') ? 'active' : '' }}">
    <a href="{!! route('account.show') !!}"><i class="fa fa-edit"></i><span> Cuenta</span></a>
</li>