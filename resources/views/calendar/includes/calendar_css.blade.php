@include('layouts.datatables_css')
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.css' />
<link rel="stylesheet" href="{{ URL::asset('css/calendar.css') }}?v={{ config('app.version') }}">
<link rel="stylesheet" href="{{ URL::asset('css/datetime.css') }}?v={{ config('app.version') }}">
<link rel="stylesheet" href="{{ URL::asset('css/wickedpicker.min.css') }}">