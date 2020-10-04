<li class="{{ Request::is('patient/professionals*') ? 'active' : '' }}">
    <a href="{!! route('patient.professionals.index') !!}"><i class="fa fa-user-md"></i><span>Médicos</span></a>
</li>

<li class="{{ Request::is('patient/appointments*') ? 'active' : '' }}">
    <a href="{!! route('patient.appointments.index') !!}"><i class="fa fa-heartbeat"></i><span>Mis Turnos</span></a>
</li>

<li class="header"> MIS DATOS</li>

<li class="{{ Request::is('patient/profile') ? 'active' : '' }}">
    <a href="{!! route('patient.profile') !!}"><i class="fa fa-user"></i><span>Perfil</span></a>
</li>

<li class="{{ Request::is('account') ? 'active' : '' }}">
    <a href="{!! route('account.show') !!}"><i class="fa fa-cog"></i><span>Cuenta</span></a>
</li>

<li class="{{ Request::is('support') ? 'active' : '' }}">
    <a href="{!! route('support.index') !!}"><i class="fa fa-question-circle"></i><span>Ayuda</span></a>
</li>