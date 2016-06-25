@extends('auth::public._template.master')

@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
            {!! Form::open(['route' => 'auth::register.post', 'method' => 'POST', 'class'  => 'form-auth form-register']) !!}
                <h2 class="heading">Welcome!</h2>
                <div class="row">
                    {{-- EMAIL --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            {!! Form::label('email', 'Email address', ['class' => 'control-label sr-only']) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                {!! Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => 'Email address', 'required' => '', 'autofocus' => '']) !!}
                            </div>
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    {{-- USERNAME --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('username') ? 'has-error' : '' }}">
                            {!! Form::label('username', 'Username', ['class' => 'control-label sr-only']) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => 'Username', 'required' => '', 'autofocus' => '']) !!}
                            </div>
                            {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="clearfix visible-lg"></div>

                    {{-- PASSWORD --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            {!! Form::label('password', 'Password', ['class' => 'control-label sr-only']) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required' => '', 'autofocus' => '']) !!}
                            </div>
                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    {{-- PASSWORD CONFIRMATION --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            {!! Form::label('password_confirmation', 'Password Confirmation', ['class' => 'control-label sr-only']) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Password confirmation', 'required' => '', 'autofocus' => '']) !!}
                            </div>
                            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="clearfix visible-lg"></div>

                    {{-- FIRST NAME --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('first_name') ? 'has-error' : '' }}">
                            {!! Form::label('first_name', 'First Name', ['class' => 'control-label sr-only']) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => 'First Name', 'required' => '', 'autofocus' => '']) !!}
                            </div>
                            {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    {{-- LAST NAME --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->has('last_name') ? 'has-error' : '' }}">
                            {!! Form::label('last_name', 'Last Name', ['class' => 'control-label sr-only']) !!}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {!! Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => 'Last Name', 'required' => '', 'autofocus' => '']) !!}
                            </div>
                            {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                {!! Form::submit('Sign up', ['class' => 'btn btn-lg btn-success btn-block']) !!}
            {!! Form::close() !!}

            <div class="form-info">
                {!! link_to_route('auth::login.get', 'Already have an account ? Sign in', [], ['class' => 'btn btn-primary btn-block']) !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
