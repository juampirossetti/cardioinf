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
        <link rel="shortcut icon" href="{{ URL::asset('ico/favicon.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ URL::asset('ico/apple-touch-icon-144-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ URL::asset('ico/apple-touch-icon-114-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ URL::asset('ico/apple-touch-icon-72-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ URL::asset('ico/apple-touch-icon-57-precomposed.png') }}">

        @include('layouts.analytics')
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
            
            <div class="inner-bg">
                <div class="container">
                    
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>SisMed</strong> Sistema de turnos médicos online </h1>
                            <div class="description">
                                <p>
                                    Ingrese su nueva contraseña. Si usted ingresó aquí por error por favor <a href="{{ url('/login') }}"><strong>Inicie sesión</strong></a>.
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            
                            <div class="form-box">
                                <div class="form-top">
                                    <div class="form-top-left">
                                        <h3>Nueva contraseña</h3>
                                        <p>Complete los datos a continuación:</p>
                                    </div>
                                    <div class="form-top-right">
                                        <i class="fa fa-lock"></i>
                                    </div>
                                </div>
                                <div class="form-bottom">
                                    <form role="form" action="{{ url('/password/reset') }}" method="post" class="login-form">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="token" value="{{ $token }}">

                                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email...">
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <input type="password" class="form-control" name="password" placeholder="Contraseña...">
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                        </div>
    
                                        <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña...">
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn">Guardar nueva contraseña!</button>
                                    
                                    </form>
                                    <div class="description text">
                                        <p><a href="{{ url('/login') }}"><strong>Iniciar sesión con mi antigua contraseña</strong></a></p>
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