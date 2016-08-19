@extends('auth::public._template.master')

<?php
$hasLoginForm    = Route::has('auth::login.get');
$hasRegisterForm = Route::has('auth::register.get');
?>
@section('content')
    <div class="row">
        <div class="col-sm-offset-2 col-sm-8 col-md-offset-3 col-md-6 col-lg-offset-3 col-lg-6">
            {{ Form::open(['route' => 'auth::password.email.post', 'method' => 'POST', 'class'  => 'form-auth form-reset-pass']) }}
                <h2 class="heading">{{ trans('auth::reset.heading') }}</h2>

                {{-- EMAIL --}}
                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                    {{ Form::label('email', trans('auth::users.email'), ['class' => 'control-label sr-only']) }}
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-at"></i></span>
                        {{ Form::email('email', old('email'), ['class' => 'form-control', 'placeholder' => trans('auth::users.email'), 'required' => '', 'autofocus' => '']) }}
                    </div>
                    {!! $errors->first('email', '<span class="help-block">:message</span>') !!}
                </div>

                {{ Form::submit(trans('auth::reset.submit'), ['class' => 'btn btn-lg btn-success btn-block']) }}
            {{ Form::close() }}

            @if ($hasLoginForm || $hasRegisterForm)
            <div class="form-info">
                @if ($hasLoginForm)
                    {!! link_to_route('auth::login.get', trans('auth::reset.links.login'), [], ['class' => 'btn btn-info btn-block']) !!}
                @endif
                @if ($hasRegisterForm)
                    {!! link_to_route('auth::register.get', trans('auth::reset.links.register'), [], ['class' => 'btn btn-primary btn-block']) !!}
                @endif
            </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
@endsection
