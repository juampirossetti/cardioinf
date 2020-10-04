<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $user->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', 'Name:') !!}
    <p>{!! $user->name !!}</p>
</div>

<!-- Email Field -->
<div class="form-group">
    {!! Form::label('email', 'Email:') !!}
    <p>{!! $user->email !!}</p>
</div>

<!-- Password Reset Field -->
<div class="form-group">
    {!! Form::label('password', 'Contraseña:') !!}
    <p>
    {!! Form::open(['route' => ['users.passwordReset', $user->id]]) !!}
    {!! Form::hidden('email', $user->email) !!}
    {!! Form::submit('Enviar email de recuperación', ['class' => 'btn btn-default']) !!}
    
    {!! Form::close() !!}
    </p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $user->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $user->updated_at !!}</p>
</div>

