<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SisMed - Sistema de turnos médicos online</title>

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
                        <p>{{ $status or '' }}</p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            
                            <div class="form-box">
                                <div class="form-top">
                                    <img src="/images/cardio_1_650.png"                         class="user-image" alt="User Image"/>
                                </div>
                                <div class="form-bottom">
                                    <form role="form" action="{{ url('/password/email') }}" method="post" class="login-form">
                                        {!! csrf_field() !!}
                                        
                                        <div class="form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email">
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn">Generar contraseña!</button>
                                    
                                    </form>
                                    <div class="description text">
                                        <p><a href="{{ url('/login') }}"><strong>Volver a la pantalla de inicio de sesión</strong></a></p>
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