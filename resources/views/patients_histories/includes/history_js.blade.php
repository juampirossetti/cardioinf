<script>localStorage.setItem('api_token','{!! $user->api_token !!}');</script>
<script type="text/javascript" src="{{ URL::asset('js/history.js') }}?v={{ config('app.version') }}"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script type="text/javascript" src="{{ URL::asset('js/professional/historias.timeline.js') }}?v={{ config('app.version') }}"></script>