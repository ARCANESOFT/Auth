<?php
/**
 * @var  Arcanesoft\Auth\Models\User      $user
 * @var  Illuminate\Support\ViewErrorBag  $errors
 */
?>

@section('header')
    <h1><i class="fa fa-fw fa-users"></i> {{ trans('auth::users.titles.users') }} <small>{{ trans('auth::users.titles.update-user') }}</small></h1>
@endsection

@section('content')
    {{ form()->open(['route' => ['admin::auth.users.update', $user->hashed_id], 'method' => 'PUT', 'id' => 'updateUserForm', 'class' => 'form form-loading']) }}
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('auth::users.titles.update-user') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                    {{ form()->label('first_name', trans('auth::users.attributes.first_name'), ['class' => 'control-label']) }}
                                    {{ form()->text('first_name', old('first_name', $user->first_name), ['class' => 'form-control']) }}
                                    @if ($errors->has('first_name'))
                                        <span class="text-red">{!! $errors->first('first_name') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('last_name', 'has-error') }}">
                                    {{ form()->label('last_name', trans('auth::users.attributes.last_name'), ['class' => 'control-label']) }}
                                    {{ form()->text('last_name', old('last_name', $user->last_name), ['class' => 'form-control']) }}
                                    @if ($errors->has('last_name'))
                                        <span class="text-red">{!! $errors->first('last_name') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('username', 'has-error') }}">
                                    {{ form()->label('username', trans('auth::users.attributes.username'), ['class' => 'control-label']) }}
                                    {{ form()->text('username', old('username', $user->username), ['class' => 'form-control']) }}
                                    @if ($errors->has('username'))
                                        <span class="text-red">{!! $errors->first('username') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                    {{ form()->label('email', trans('auth::users.attributes.email'), ['class' => 'control-label']) }}
                                    {{ form()->email('email', old('email', $user->email), ['class' => 'form-control']) }}
                                    @if ($errors->has('email'))
                                        <span class="text-red">{!! $errors->first('email') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                    {{ form()->label('password', trans('auth::users.attributes.password'), ['class' => 'control-label']) }}
                                    {{ form()->password('password', ['class' => 'form-control']) }}
                                    @if ($errors->has('password'))
                                        <span class="text-red">{!! $errors->first('password') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('password_confirmation', 'has-error') }}">
                                    {{ form()->label('password_confirmation', trans('auth::users.attributes.password_confirmation'), ['class' => 'control-label']) }}
                                    {{ form()->password('password_confirmation', ['class' => 'form-control']) }}
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-red">{!! $errors->first('password_confirmation') !!}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {{ ui_link('cancel', route('admin::auth.users.index')) }}
                        {{ ui_button('update', 'submit')->appendClass('pull-right')->withLoadingText() }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @include('auth::admin.users._partials.roles-checkbox', ['old' => collect(old('roles', $user->roles->pluck('id', 'id')))])
            </div>
        </div>
    {{ form()->close() }}
@endsection

@section('scripts')
@endsection
