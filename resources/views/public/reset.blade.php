@extends('auth::public._template.master')

@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
            {!! Form::open(['route' => 'auth::password.email.post', 'method' => 'POST', 'class'  => 'form-auth form-reset-pass']) !!}
                <h2 class="heading">Have you forgotten your password?</h2>

                {{-- EMAIL --}}
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    {!! Form::label('email', 'Email address', ['class' => 'control-label sr-only']) !!}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-at"></i></span>
                        {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email address', 'required' => '', 'autofocus' => '']) !!}
                    </div>
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>

                {!! Form::submit('Send Password Reset Link', ['class' => 'btn btn-lg btn-success btn-block']) !!}
            {!! Form::close() !!}

            <div class="form-info">
                {!! link_to_route('auth::login.get', 'You\'ve remembered your password? Sign in', [], ['class' => 'btn btn-info btn-block']) !!}
                @if (config('arcanesoft.auth.authentication.register.enabled', true))
                    {!! link_to_route('auth::register.get', 'Don\'t have an account? Sign up', [], ['class' => 'btn btn-primary btn-block']) !!}
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
