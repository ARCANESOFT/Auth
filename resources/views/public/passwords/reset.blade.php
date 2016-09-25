@extends('_template.default.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('auth::password.heading') }}</div>

                    <div class="panel-body">
                        {{ Form::open(['route' => 'auth::password.post', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal']) }}
                            {{ Form::hidden('token', $token) }}

                            <div class="form-group{{ $errors->first('email', ' has-error') }}">
                                {{ Form::label('email', trans('auth::users.email'), ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::email('email', $email or old('email'), ['class' => 'form-control', 'required', 'autofocus']) }}
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('password', ' has-error') }}">
                                {{ Form::label('password', trans('auth::users.password'), ['class' => 'col-md-4 control-label']) }}
                                <div class="col-md-6">
                                    {{ Form::password('password', ['class' => 'form-control', 'required']) }}
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('password_confirmation', ' has-error') }}">
                                {{ Form::label('password_confirmation', trans('auth::users.password_confirmation'), ['class' => 'col-md-4 control-label']) }}
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
                                    {{ Form::button(trans('auth::password.submit'), ['type' => 'submit', 'class' => 'btn btn-primary']) }}
                                </div>
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection