@extends('auth::public._template.master')

<?php
$hasLoginForm = Route::has('auth::login.get');
?>
@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
            {{ Form::open(['route' => 'auth::register.post', 'method' => 'POST', 'class'  => 'form-auth form-register']) }}
                <h2 class="heading">{{ trans('auth::register.heading') }}</h2>
                <div class="row">
                    {{-- EMAIL --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->first('email', 'has-error') }}">
                            {{ Form::label('email', trans('auth::users.email'), ['class' => 'control-label sr-only']) }}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-at"></i></span>
                                {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('auth::users.email'), 'required' => '', 'autofocus' => '']) }}
                            </div>
                            {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    {{-- USERNAME --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->first('username', 'has-error') }}">
                            {{ Form::label('username', trans('auth::users.username'), ['class' => 'control-label sr-only']) }}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {{ Form::text('username', old('username'), ['class' => 'form-control', 'placeholder' => trans('auth::users.username'), 'required' => '', 'autofocus' => '']) }}
                            </div>
                            {!! $errors->first('username', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="clearfix visible-lg"></div>

                    {{-- PASSWORD --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->first('password', 'has-error') }}">
                            {{ Form::label('password', trans('auth::users.password'), ['class' => 'control-label sr-only']) }}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('auth::users.password'), 'required' => '', 'autofocus' => '']) }}
                            </div>
                            {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                    {{-- PASSWORD CONFIRMATION --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->first('password_confirmation', 'has-error') }}">
                            {{ Form::label('password_confirmation', trans('auth::users.email'), ['class' => 'control-label sr-only']) }}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => trans('auth::users.password_confirmation'), 'required' => '', 'autofocus' => '']) }}
                            </div>
                            {!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    <div class="clearfix visible-lg"></div>

                    {{-- FIRST NAME --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                            {{ Form::label('first_name', trans('auth::users.first_name'), ['class' => 'control-label sr-only']) }}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {{ Form::text('first_name', old('first_name'), ['class' => 'form-control', 'placeholder' => trans('auth::users.first_name'), 'required' => '', 'autofocus' => '']) }}
                            </div>
                            {!! $errors->first('first_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>

                    {{-- LAST NAME --}}
                    <div class="col-lg-6">
                        <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                            {{ Form::label('last_name', trans('auth::users.last_name'), ['class' => 'control-label sr-only']) }}
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                {{ Form::text('last_name', old('last_name'), ['class' => 'form-control', 'placeholder' => trans('auth::users.last_name'), 'required' => '', 'autofocus' => '']) }}
                            </div>
                            {!! $errors->first('last_name', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
                {{ Form::button(trans('auth::register.submit'), ['type' => 'submit', 'class' => 'btn btn-lg btn-success btn-block']) }}
            {{ Form::close() }}

            @if ($hasLoginForm)
                <div class="form-info">
                    {{ link_to_route('auth::login.get', trans('auth::register.links.login'), [], ['class' => 'btn btn-primary btn-block']) }}
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
@endsection
