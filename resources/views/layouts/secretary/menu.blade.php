<li class="header"> MENÚ DE SECRETARIA</li>

<li class="{{ Request::is('*/calendar*') ? 'active' : '' }}">
    <a href="{!! route('calendar.index') !!}"><i class="fa fa-calendar"></i><span> Calendario</span></a>
</li>

<li class="{{ Request::is('*/appointmentslist*') ? 'active' : '' }}">
    <a href="{!! route('appointmentslist.index') !!}"><i class="fa fa-search"></i><span> Buscar turnos</span></a>
</li>

<li class="{{ Request::is('*/patients*') ? 'active' : '' }}">
    <a href="{!! route('patients.index') !!}"><i class="fa fa-users"></i><span> Pacientes</span></a>
</li>

<li class="{{ Request::is('management/historias*') ? 'active' : '' }}">
    <a href="{!! route('historias.index') !!}"><i class="fa fa-star"></i><span> Historias Clínicas</span></a>
</li>

<li class="{{ Request::is('*/mailbox*') ? 'active' : '' }}">
    <a href="{!! route('mailbox.index') !!}"><i class="fa fa-envelope"></i><span> Emails</span></a>
</li>

<!-- <li class="{{ Request::is('*/histories*') ? 'active' : '' }}">
    <a href="{!! route('histories.index') !!}"><i class="fa fa-file-text-o"></i><span>Historias Clínicas</span></a>
</li> -->


<li class="treeview {{ Request::is('*/configuration*') ? 'active' : '' }}">
    <a href="#">
        <i class="fa fa-briefcase"></i>
        <span> Gestión</span>
        <i class="fa fa-angle-left pull-right"></i>
    </a>                            

    <ul class="treeview-menu">
        <li class="treeview {{ Request::is('*/professionals*') ? 'active' : '' }}">
            <a href="{!! route('professionals.index') !!}">
                <i class="fa fa-user-md"></i> Médicos
            </a>
        </li>
        <li class="treeview {{ Request::is('*/timetables*') ? 'active' : '' }}">
            <a href="{!! route('timetables.index') !!}">
                <i class="fa fa-clock-o"></i> Horarios de consulta
            </a>
        </li>

        <li class="treeview {{ Request::is('*/exceptions*') ? 'active' : '' }}">
            <a href="{!! route('exceptionsdays.index') !!}">
                <i class="fa fa-exchange"></i> Excepciones de consultas
            </a>
        </li>

        <li class="treeview {{ Request::is('*/insurances*') ? 'active' : '' }}">
            <a href="{!! route('insurances.index') !!}">
                <i class="fa fa-list"></i> Obras Sociales
            </a>
        </li>

        <li class="treeview {{ Request::is('*/indications*') ? 'active' : '' }}">
            <a href="{!! route('indications.index') !!}">
                <i class="fa fa-info-circle"></i> Indicaciones
            </a>
        </li>

        <li class="treeview {{ Request::is('*/medicalStudies*') ? 'active' : '' }}">
            <a href="{!! route('medicalStudies.index') !!}">
                <i class="fa fa-file-text-o"></i> Estudios médicos
            </a>

        </li>
    </ul>
</li>

<li class="header"> MIS DATOS</li>

<li class="{{ Request::is('account') ? 'active' : '' }}">
    <a href="{!! route('account.show') !!}"><i class="fa fa-edit"></i><span> Cuenta</span></a>
</li>

<!-- <li class="{{ Request::is('professionals*') ? 'active' : '' }}">
    <a href="{!! route('professionals.index') !!}"><i class="fa fa-edit"></i><span>Médicos</span></a>
</li>

<li class="{{ Request::is('insurances*') ? 'active' : '' }}">
    <a href="{!! route('insurances.index') !!}"><i class="fa fa-edit"></i><span>Obras Sociales</span></a>
</li> -->


<!-- <li class="{{ Request::is('timetables*') ? 'active' : '' }}">
    <a href="{!! route('timetables.index') !!}"><i class="fa fa-edit"></i><span>Horarios</span></a>
</li> -->



<!-- <li class="{{ Request::is('medicalStudies*') ? 'active' : '' }}">
    <a href="{!! route('medicalStudies.index') !!}"><i class="fa fa-edit"></i><span>Estudios médicos</span></a>
</li> -->
