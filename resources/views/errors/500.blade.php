<!DOCTYPE html>
<html>
    <head>
        <title>Página no encontrada.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                color: #B0BEC5;
                display: table;
                font-weight: 100;
                font-family: 'Lato', sans-serif;
            }

            .container {
                text-align: center;
                display: table-cell;
                vertical-align: middle;
            }

            .content {
                text-align: center;
                display: inline-block;
            }

            .title {
                font-size: 72px;
                margin-bottom: 40px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div class="title">Algo no funcionó correctamente.</div>

                @if(app()->bound('sentry') && !empty(Sentry::getLastEventID()))
                    <div class="subtitle">Error ID: {{ Sentry::getLastEventID() }}</div>

                <!-- Sentry JS SDK 2.1.+ required -->
                <script src="https://cdn.ravenjs.com/3.3.0/raven.min.js"></script>

                <script>
                    Raven.showReportDialog({
                        eventId: '{{ Sentry::getLastEventID() }}',
                        // use the public DSN (dont include your secret!)
                        dsn: 'https://e9ebbd88548a441288393c457ec90441@sentry.io/3235',
                        @if (!Auth::guest())
                        user: {
                            'name': {!! Auth::user()->name !!},
                            'email': {!! Auth::user()->email !!},
                        }
                        @else
                        user: {
                            'name': 'guest',
                            'email': 'noemail@noemail.com',
                        }
                        @endif
                    });
                </script>
                @endif
            </div>
        </div>
    </body>
</html>