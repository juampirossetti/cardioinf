<div class="col-lg-4 col-md-6 col-xs-12">
    <div class="form-group">
        {!! Form::label('email', 'Email de la cuenta:') !!}
        {!! Form::text('email', $user->email, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('password', 'Contraseña:') !!}
        {!! Form::password('password', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('confirm_password', 'Confirmar contraseña:') !!}
        {!! Form::password('confirm_password', null, ['class' => 'form-control']) !!}
    </div>

    <!-- Submit Field -->
    <div class="form-group">
        {!! Form::submit('Actualizar', ['class' => 'btn btn-primary']) !!}
        <a href="{!! url('/') !!}" class="btn btn-default pull-right">Volver</a>
    </div>    
</div>