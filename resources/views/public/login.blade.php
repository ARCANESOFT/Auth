@extends('auth::public._template.master')

<?php
$hasRegisterForm = Route::has('auth::register.get');
$hasResetForm    = Route::has('auth::password.email.get');
?>
@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-4 col-lg-4">
            {{ Form::open(['route' => 'auth::login.post', 'method' => 'POST', 'class'  => 'form-auth form-login']) }}
                <h2 class="heading">{{ trans('auth::login.heading') }}</h2>
                {{-- EMAIL --}}
                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                    {{ Form::label('email', trans('auth::users.email'), ['class' => 'control-label sr-only']) }}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-at"></i></span>
                        {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('auth::users.email'), 'required' => '', 'autofocus' => '']) }}
                    </div>
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>
                {{-- PASSWORD --}}
                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                    {{ Form::label('password', trans('auth::users.password'), ['class' => 'control-label sr-only']) }}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-key"></i></span>
                        {{ Form::password('password', ['class' => 'form-control', 'placeholder' => trans('auth::users.password'), 'required' => '']) }}
                    </div>
                    {!! $errors->first('password', '<span class="help-block">:message</span>') !!}
                </div>
                {{-- REMEMBER ME --}}
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('remember') }} {{ trans('auth::login.remember') }}
                    </label>
                </div>
                {{ Form::button(trans('auth::login.submit'), ['type' => 'submit', 'class' => 'btn btn-lg btn-success btn-block']) }}
            {{ Form::close() }}

            @if ($hasRegisterForm || $hasResetForm)
                <div class="form-info">
                    @if ($hasRegisterForm)
                        {{ link_to_route('auth::register.get', trans('auth::login.links.register'), [], ['class' => 'btn btn-primary btn-block']) }}
                    @endif
                    @if ($hasResetForm)
                        {{ link_to_route('auth::password.email.get', trans('auth::login.links.reset'), [], ['class' => 'btn btn-warning btn-block']) }}
                    @endif
                </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
@endsection
