<!-- <script src="//code.jquery.com/jquery-1.11.3.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/i18n/es.js"></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/es.js'></script>
<script type="text/javascript" src="{{ URL::asset('js/wickedpicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/printThis.js') }}?v={{ config('app.version') }}"></script>
<script>localStorage.setItem('api_token','{!! $user->api_token !!}');</script>
<script type="text/javascript" src="{{ URL::asset('js/call/secretary.js') }}?v={{ config('app.version') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/calendar.js') }}?v={{ config('app.version') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/sendEmail.js') }}?v={{ config('app.version') }}"></script>
@include('layouts.datatables_js')
<script type="text/javascript" src="{{ URL::asset('js/secretary/calendar.search.js') }}?v={{ config('app.version') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/secretary/calendar.user.js') }}?v={{ config('app.version') }}"></script>