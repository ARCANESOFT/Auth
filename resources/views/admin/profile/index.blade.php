<?php /** @var  Arcanesoft\Auth\Models\User  $user */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-user"></i> Profile <small>{{ $user->full_name }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-blue">
                    <div class="widget-user-image">
                        {{ html()->image($user->gravatar, $user->full_name, ['class' => 'img-circle']) }}
                    </div>
                    <h3 class="widget-user-username">{{ $user->full_name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->since_date }}</h5>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                                <tr>
                                    <th>{{ trans('auth::users.attributes.username') }} :</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::users.attributes.email') }} :</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.status') }} :</th>
                                    <td>
                                        @includeWhen($user->isAdmin(), 'auth::admin.users._includes.super-admin-label')
                                        {{ label_active_status($user->isActive()) }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.created_at') }} :</th>
                                    <td><small>{{ $user->created_at }}</small></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.updated_at') }} :</th>
                                    <td><small>{{ $user->updated_at }}</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- EDIT PASSWORD --}}
            {{ form()->open(['route' => ['admin::auth.profile.password.update', $user->hashed_id], 'method' => 'PUT', 'id' => 'updatePasswordForm', 'class' => 'form form-loading']) }}
                <div class="box box-danger">
                    <div class="box-header with-border">
                        <h2 class="box-title">{{ trans('auth::profile.titles.password') }}</h2>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->first('old_password', 'has-error') }}">
                            {{ form()->label('old_password', trans('auth::profile.attributes.old-password').' :', ['class' => 'control-label']) }}
                            {{ form()->password('old_password', ['class' => 'form-control']) }}
                            @if ($errors->has('old_password'))
                                <span class="text-red">{!! $errors->first('old_password') !!}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('password', 'has-error') }}">
                            {{ form()->label('password', trans('auth::profile.attributes.new-password').' :', ['class' => 'control-label']) }}
                            {{ form()->password('password', ['class' => 'form-control']) }}
                            @if ($errors->has('password'))
                                <span class="text-red">{!! $errors->first('password') !!}</span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->first('password_confirmation', 'has-error') }}">
                            {{ form()->label('password_confirmation', trans('auth::users.attributes.password_confirmation'), ['class' => 'control-label']) }}
                            {{ form()->password('password_confirmation', ['class' => 'form-control']) }}
                            @if ($errors->has('password_confirmation'))
                                <span class="text-red">{!! $errors->first('password_confirmation') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        {{ ui_button('update', 'submit')->withLoadingText() }}
                    </div>
                </div>
            {{ form()->close() }}
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a aria-expanded="false" href="#settings" data-toggle="tab">{{ trans('auth::profile.titles.settings') }}</a>
                    </li>
                </ul>
                <div class="tab-content">
                    {{-- SETTINGS --}}
                    <div id="settings" class="tab-pane active">
                        {{-- EMPTY --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
