@extends('_template.default.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">
                        {{ Form::open(['route' => 'auth::register.post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) }}
                            <div class="form-group{{ $errors->first('username', ' has-error') }}">
                                {{ Form::label('username', 'Username', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::text('username', old('username'), ['class' => 'form-control', 'required', 'autofocus']) }}
                                    @if ($errors->has('username'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('username') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('first_name', ' has-error') }}">
                                {{ Form::label('first_name', 'First Name', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'required', 'autofocus']) }}
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('last_name', ' has-error') }}">
                                {{ Form::label('last_name', 'Last Name', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'required', 'autofocus']) }}
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('email', ' has-error') }}">
                                {{ Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'required']) }}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('password', ' has-error') }}">
                                {{ Form::label('password', 'Password', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::password('password', ['class' => 'form-control', 'required']) }}
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                {{ Form::label('password_confirmation', 'Confirm Password', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::password('password_confirmation', ['class' => 'form-control', 'required']) }}

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    {{ Form::button('Register', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
