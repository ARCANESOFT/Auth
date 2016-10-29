@extends('_template.default.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ trans('auth::password.heading') }}</div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        {{ Form::open(['route' => 'auth::password.email', 'role' => 'form', 'method' => 'POST']) }}
                            <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-fw fa-at"></i></span>
                                    {{ Form::email('email', old('email'), ['class' => 'form-control', 'required', 'autofocus', 'placeholder' => trans('auth::users.email')]) }}
                                </div>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                {{ Form::button(trans('auth::password.submit'), ['type' => 'submit', 'class' => 'btn btn-block btn-primary']) }}
                            </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
