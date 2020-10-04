<aside class="main-sidebar" id="sidebar-wrapper">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        
        <ul class="sidebar-menu">
                <!-- TODO: Filtrar las rutas por rol -->
                @if (Request::is('admin*'))
                        @include('layouts.admin.menu')
                @elseif (Request::is('secretary*'))
                        @include('layouts.secretary.menu')
                @elseif (Request::is('professional*'))
                    @role('professional')
                        @include('layouts.professional.menu')
                    @endrole
                @else
                    @role('patient')
                        @include('layouts.patient.menu')
                    @endrole

                    @role('secretary')
                        @include('layouts.secretary.menu')
                    @endrole

                    @role('professional')
                        @include('layouts.professional.menu')
                    @endrole

                @endif
                
            
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>