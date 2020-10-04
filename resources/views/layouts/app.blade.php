<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sistema de turnos</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/css/AdminLTE.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/css/skins/_all-skins.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ URL::asset('css/common.css') }}?v={{ config('app.version') }}">
    @yield('css')
    @stack('styles')

    @if (Auth::user()->hasRole(['secretary']))
        <link rel="stylesheet" href="{{ URL::asset('css/secretary.css') }}?v={{ config('app.version') }}">
    @endif

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="{{ URL::asset('ico/favicon.ico') }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::asset('ico/apple-touch-icon-144-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::asset('ico/apple-touch-icon-114-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::asset('ico/apple-touch-icon-72-precomposed.png') }}">
    <link rel="apple-touch-icon-precomposed" href="{{ URL::asset('ico/apple-touch-icon-57-precomposed.png') }}">
    <link rel="apple-touch-icon" sizes="57x57" href="/ico/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/ico/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/ico/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/ico/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/ico/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/ico/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/ico/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/ico/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/ico/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/ico/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/ico/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/ico/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/ico/favicon-16x16.png">
    <link rel="manifest" href="/ico/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ico/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-117512958-1"></script>
    @include('layouts.analytics')


</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="loader"></div>
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="#" class="logo">
                <span class="logo-lg">Cardio<b>INFANTIL</b></span>
                <span class="mini-logo">C<b>I</b></span>
                
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- <li>
                            <a href="#"><i class="glyphicon glyphicon-question-sign"></i> Ayuda</a>
                        </li> -->
                      <li class="dropdown user-top-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                          <!-- The user image in the navbar-->
                          <img src="/ico/ms-icon-150x150.png"
                          class="user-image" alt="User Image"/>
                          <!-- hidden-xs hides the username on small devices so only the image appears. -->
                          @if (Auth::user()->hasRole(['patient']))
                            <span class="hidden-xs">{!! Auth::user()->patient->name !!}</span>
                          @else
                            <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                          @endif
                          <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                        @if (Auth::user()->hasRole(['patient']))
                          <li><a href="{{route('patient.profile')}}">Perfil</a></li>
                          <li class="divider"></li>
                        @endif
                        @if (Auth::user()->hasRole(['secretary']))
                          <li><a href="{{route('system.index')}}">
                            <span class="glyphicon glyphicon-cog"></span>Configuración</a></li>
                          <li class="divider"></li>
                        @endif
                        @if (Auth::user()->hasRole(['admin']))
                          <li><a href="{{route('admin.system.index')}}">
                            <span class="glyphicon glyphicon-cog"></span>Configuración</a></li>
                          <li class="divider"></li>
                        @endif
                          <li>
                            <a href="{!! url('/logout') !!}" 
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <span class="glyphicon glyphicon-off"></span>Salir
                            </a>
                            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                          </li>
                        </ul>
                      </li>
                    </ul>
                </div>
            </nav>
        </header>

        <!-- Left side column. contains the logo and sidebar -->
        @include('layouts.sidebar')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>

        <!-- Main Footer -->
        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © 2017 <a href="http://girosit.com">GirosIT</a>.</strong> Todos los derechos reservados.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{!! url('/') !!}">
                    InfyOm Generator
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery 2.1.4 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
    <!-- AdminLTE App -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/js/app.min.js"></script>
    <script type="text/javascript">
        $(window).load(function() {
            $(".loader").fadeOut("slow");
        });
    </script>
    @yield('scripts')
    @stack('javascript')
</body>
</html>