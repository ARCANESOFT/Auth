@extends('_template.default.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
                    <div class="panel-body">
                        {{ Form::open(['route' => 'auth::login.post', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'POST']) }}
                            <div class="form-group{{ $errors->first('email', ' has-error') }}">
                                {{ Form::label('email', 'E-Mail Address', ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'required', 'autofocus']) }}

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

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            {{ Form::checkbox('remember') }} Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    {{ Form::button('Login', ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                    {{ link_to_route('auth::password.get', 'Forgot Your Password?', [], ['class' => 'btn btn-link']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
