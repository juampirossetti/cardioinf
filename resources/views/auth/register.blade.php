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
                        <div class="col-md-offset-3 col-md-6">
                            
                            <div class="form-box">
                                <div class="form-top">
                                     <img src="/images/cardio_1_650.png"                         class="user-image" alt="User Image"/>
                                </div>
                                <div class="form-bottom">
                                    <form role="form" action="{{ url('/register') }}" method="post" class="login-form">
                                        {!! csrf_field() !!}
                                        <div class="login-label">Datos personales</div>
                                        <div class="form-group has-feedback{{ $errors->has('name') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Nombre...">
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>

                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                            {{ $errors->first('name') }}
                                            </span>
                                        @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('surname') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control" name="surname" value="{{ old('surname') }}" placeholder="Apellido...">
                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
    
                                            @if ($errors->has('surname'))
                                                <span class="help-block">
                                                {{ $errors->first('surname') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('dni') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control" name="dni" value="{{ old('dni') }}" placeholder="Documento...">
                                            <span class="glyphicon glyphicon-book form-control-feedback"></span>

                                            @if ($errors->has('dni'))
                                                <span class="help-block">
                                                {{ $errors->first('dni') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('address') ? ' has-error' : '' }}">
                                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Dirección...">
                                            <span class="glyphicon glyphicon-home form-control-feedback"></span>

                                            @if ($errors->has('address'))
                                                <span class="help-block">
                                                {{ $errors->first('address') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('primary_phone') ? ' has-error' : '' }}">
                                            <div class="row">
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="char_phone" value="{{ old('char_phone') }}" placeholder="Característica Cel...">
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="primary_phone" value="{{ old('primary_phone') }}" placeholder="Celular...">
                                                <span class="glyphicon glyphicon-phone form-control-feedback inline-span"></span>
                                            </div>
                                            <div class="col-sm-12">
                                            @if ($errors->has('primary_phone'))
                                                <span class="help-block">
                                                {{ $errors->first('primary_phone') }}
                                                </span>
                                            @endif
                                            </div>
                                            </div>
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('secondary_phone') ? ' has-error' : '' }}">
                                            <div class="row">
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="char_phone_2" value="{{ old('char_phone_2') }}" placeholder="Característica Fijo...">
                                            </div>
                                            
                                            <div class="col-sm-6">
                                                <input type="number" class="form-control" name="secondary_phone" value="{{ old('secondary_phone') }}" placeholder="Tel. Fijo...">
                                                <span class="glyphicon glyphicon-earphone form-control-feedback inline-span"></span>
                                            </div>
                                            <div class="col-sm-12">
                                            @if ($errors->has('secondary_phone'))
                                                <span class="help-block">
                                                {{ $errors->first('secondary_phone') }}
                                                </span>
                                            @endif
                                            </div>
                                            </div>
                                        </div>

                                        <div class="login-label">Datos de cuenta</div>

                                        <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email...">
                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    
                                            @if ($errors->has('email'))
                                                <span class="help-block">
                                                {{ $errors->first('email') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="help-text">La contraseña que carguen no debe ser la de su email original. Es una contraseña nueva que se utiliza sólamente para iniciar sesión en nuestro sistema ¡Recuérdela porque la va a necesitar siempre!</div>
                                        
                                        <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <input type="password" class="form-control" name="password" placeholder="Contraseña...">
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>

                                            @if ($errors->has('password'))
                                                <span class="help-block">
                                                {{ $errors->first('password') }}
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group has-feedback{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmar contraseña...">
                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        
                                            @if ($errors->has('password_confirmation'))
                                                <span class="help-block">
                                                {{ $errors->first('password_confirmation') }}
                                                </span>
                                            @endif
                                        </div>
                                        <button type="submit" class="btn">Registrarme</button>
                                    </form>
                                    <div class="description text">
                                        
                                        <p><a href="{{ url('/login') }}" class="text-center"><strong>Ya tengo un usuario</strong></a></p>
                                        <p><a href="{{ url('/password/reset') }}"><strong>He olvidado mi contraseña</strong></a></p>
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