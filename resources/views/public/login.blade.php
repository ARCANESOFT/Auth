@extends('auth::public._template.master')

@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
            {!! Form::open(['route' => 'auth::login.post', 'method' => 'POST', 'class'  => 'form-auth form-login']) !!}
                <h2 class="heading">Welcome Back!</h2>
                {{-- EMAIL --}}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', 'Email address', ['class' => 'control-label sr-only']) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-at"></i></span>
                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email address', 'required' => '', 'autofocus' => '']) !!}
                    </div>
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
                {{-- PASSWORD --}}
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    {!! Form::label('password', 'Password', ['class' => 'control-label sr-only']) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => '']) !!}
                    </div>
                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                </div>
                {{-- REMEMBER ME --}}
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('remember') !!} Remember Me
                    </label>
                </div>
                {!! Form::submit('Sign in', ['class' => 'btn btn-lg btn-success btn-block']) !!}
            {!! Form::close() !!}

            <div class="form-info">
                {!! link_to_route('auth::register.get', 'Don\'t have an account? Sign up', [], ['class' => 'btn btn-primary btn-block']) !!}
                {!! link_to_route('auth::password.email.get', 'Have you forgotten your password?', [], ['class' => 'btn btn-warning btn-block']) !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
