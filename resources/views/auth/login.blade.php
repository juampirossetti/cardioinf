<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SisMed - Sistema de turnos médicos online de la Clínica de Cardiología Infantil</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        
        <link rel="stylesheet" href="{{ URL::asset('auth/css/form-elements.css') }}?v={{ config('app.version') }}">
        
        <link rel="stylesheet" href="{{ URL::asset('auth/css/style.css') }}?v={{ config('app.version') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

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

        @include('layouts.analytics')

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    @if (session('message'))
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div class="form-top">
                                <div class="form-top-center">
                                    <h3>{{session('message')}}</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            
                            <div class="form-box">
                                <div class="form-top">
                                    <img src="/images/cardio_1_650.png" class="user-image" alt="User Image"/>
                                <div style="font-weight: bold;">
                                    <p>Comunicamos que el Centro comenzara la atencion de sus pacientes a partir del Lunes 13 de Abril, en los
                                        horarios habituales.</p>
                                    <p>Para turnos:</p>
                                    <ul>
                                        <li>Comunicarse al telefono del Centro 0342-4565514 de 15 a 19 hs. los dias Lunes, Miercoles y
                                            Jueves y de 12 a 16 hs. los dias Martes y Viernes.</li>
                                        <li><p style="margin-bottom: 0px;">Por la pagina web o por mail centrocardiologiainfantil</p><p style="margin-left: 40px;">@gmail.com</p></li>
                                    </ul>

                                    <p>Acorde a las normas dictadas por los Ministerios de Salud Nacional y Provincial solicitamos:</p>
                                    <ul>
                                        <li>Respetar los horarios del turno, para evitar aglomeraciones</li>
                                        <li>El ingreso al Centro debe ser con un solo mayor acompañante, en lo posible menor de 60 años y
                                            respetando el distanciamiento aconsejado.</li>
                                        <li>De ser posible, concurrir con barbijos.</li>
                                    </ul>
                                    <p>Agradecemos su colaboracion.</p>
                                </div>
                                </div>
                                
                                <div class="form-bottom">
                                    <form role="form" action="{{ url('/login') }}" method="post" class="login-form" id="login-form">
                                        {!! csrf_field() !!}
                                        
                                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <label class="login-label">Email [ requerido ]</label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" placeholder="Email">
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <label class="login-label">Contraseña [ requerido ]</label>
                                            <input type="password" class="form-control" placeholder="Contraseña" name="password">
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                {{ $errors->first('password') }}    
                                                </span>
                                            @endif

                                        </div>

                                        <button type="submit" class="btn" id="ingresar">Ingresar!</button>
                                    
                                    </form>
                                    <div class="description text">
                                        <p><a href="{{ url('/password/reset') }}"><strong>He olvidado mi contraseña</strong></a></p>
                                        @if(SMConfig::getByKey('user_from_login'))
                                            <p><a href="{{ url('/register') }}" id="register"><strong>Registrarme como nuevo usuario</strong></a></p>
                                        @endif
                                    </div>  
                                </div>
                            </div>
                              
                                                    
                        </div>
                        
                    </div>
                    
                </div>
            </div>
            
        </div>

        <!-- Footer -->
        <footer>
            <div class="container">
                <div class="row">
                    
                    <div class="col-sm-8 col-sm-offset-2">
                        <div class="footer-border"></div>
                        <p>Desarrollado y hosteado por <a href="http://girosit.com" target="_blank"><strong>GirosIT</strong></a>. <i class="fa fa-smile-o"></i></p>
                    </div>
                    
                </div>
            </div>
        </footer>

        <!-- Javascript -->

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="{{ URL::asset('auth/js/jquery.backstretch.min.js') }}"></script>
        <script src="{{ URL::asset('auth/js/scripts.js') }}?v={{ config('app.version') }}"></script>

        <!-- AdminLTE App -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.3/js/app.min.js"></script>

        <script type="text/javascript">
            var ASSET_URL = {!! json_encode(URL::asset('/')) !!}
        </script>        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>