{!! Form::open(['route' => null, 'class' => 'form', 'id' => 'newPatientForm']) !!}
  {{ Form::hidden('api_token',$user->api_token)}}
  {{ Form::hidden('dni', null) }}
  {{ Form::hidden('name', null) }}
  {{ Form::hidden('surname', null) }}
  {{ Form::hidden('address', null) }}
  {{ Form::hidden('primary_phone', null) }}
  {{ Form::hidden('secondary_phone', null) }}
  {{ Form::hidden('affiliate_number', null) }}
  {{ Form::hidden('insurance_id', null) }}
  {{ Form::hidden('professional', null) }}
  {{ Form::hidden('plan', null) }}
  {{ Form::hidden('email', null) }}

{!! Form::close() !!}