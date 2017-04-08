<?php /** @var  \Arcanesoft\Auth\Models\User  $user */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-users"></i> {{ trans('auth::users.titles.users') }} <small>{{ trans('auth::users.titles.user-details') }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-5">
            {{-- USER DETAILS --}}
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-blue">
                    <div class="widget-user-image">
                        {{ html()->image($user->gravatar, $user->full_name, ['class' => 'img-circle']) }}
                    </div>
                    <h3 class="widget-user-username">{{ $user->full_name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->since_date }}</h5>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <thead>
                                <tr>
                                    <th>{{ trans('auth::users.attributes.username') }} :</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>{{ trans('auth::users.attributes.first_name') }} :</th>
                                    <td>{{ $user->first_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::users.attributes.last_name') }} :</th>
                                    <td>{{ $user->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::users.attributes.email') }} :</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::users.attributes.last_activity') }} :</th>
                                    <td><small>{{ $user->formatted_last_activity }}</small></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.status') }} :</th>
                                    <td>
                                        @includeWhen($user->isAdmin(), 'auth::admin.users._includes.super-admin-label')
                                        {{ label_active_status($user->isActive()) }}
                                        {{ $user->trashed() ? label_trashed_status() : '' }}
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
                                @if ($user->trashed())
                                    <tr>
                                        <th>{{ trans('core::generals.deleted_at') }} :</th>
                                        <td><small>{{ $user->deleted_at }}</small></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    @if (Arcanedev\LaravelAuth\Services\UserImpersonator::isEnabled() && $user->canBeImpersonated())
                        <a href="{{ route('admin::auth.users.impersonate', [$user->hashed_id]) }}" class="btn btn-sm btn-default">
                            <i class="fa fa-fw fa-user-secret"></i> Impersonate
                        </a>
                    @endif

                    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
                        @include('core::admin._includes.actions.links.edit', ['url' => route('admin::auth.users.edit', [$user->hashed_id])])
                        @include('core::admin._includes.actions.links.'.($user->isActive() ? 'disable' : 'enable'), $user->isAdmin() ? ['disabled' => true] : ['url' => '#activateUserModal'])
                        @includeWhen($user->trashed(), 'core::admin._includes.actions.links.restore', ['url' => '#restoreUserModal'])
                    @endcan

                    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
                        @include('core::admin._includes.actions.links.delete', $user->isAdmin() ? ['disabled' => true] : ['url' => '#deleteUserModal'])
                    @endcan
                </div>
            </div>

            {{-- PASSWORD RESET TABLE --}}
            @includeWhen($user->hasPasswordReset(), 'auth::admin.users._includes.password-reset-table')
        </div>
        <div class="col-sm-7">
            {{-- ROLES TABLE --}}
            @include('auth::admin.users._includes.roles-table', ['roles' => $user->roles])
        </div>
    </div>
@endsection

@section('modals')
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE MODAL --}}
        <div id="activateUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::auth.users.activate', $user->hashed_id], 'method' => 'PUT', 'id' => 'activateUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="activateUserModalLabel">
                            {{ $user->isActive() ? 'Disable User' : 'Activate User' }}
                        </h4>
                    </div>
                    <div class="modal-body">
                        @if ($user->isActive())
                            <p>Are you sure you want to <span class="label label-inverse">disable</span> this user : <strong>{{ $user->full_name }}</strong> ?</p>
                        @else
                            <p>Are you sure you want to <span class="label label-success">activate</span> this user : <strong>{{ $user->full_name }}</strong> ?</p>
                        @endif
                    </div>
                    <div class="modal-footer">
                        {{ Form::button('Cancel', ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                        @if ($user->isActive())
                            <button id="disableBtn" type="submit" class="btn btn-sm btn-inverse" data-loading-text="Loading&hellip;">
                                <i class="fa fa-fw fa-power-off"></i> Disable
                            </button>
                        @else
                            <button id="activateBtn" type="submit" class="btn btn-sm btn-success" data-loading-text="Loading&hellip;">
                                <i class="fa fa-fw fa-power-off"></i> Activate
                            </button>
                        @endif
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>

        {{-- RESTORE MODAL --}}
        @if ($user->trashed())
            <div id="restoreUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreUserModalLabel">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['route' => ['admin::auth.users.restore', $user->hashed_id], 'method' => 'PUT', 'id' => 'restoreUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="restoreUserModalLabel">Restore User</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <span class="label label-primary">restore</span> this user : <strong>{{ $user->full_name }}</strong> ?</p>
                            </div>
                            <div class="modal-footer">
                                {{ Form::button('Cancel', ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                                <button type="submit" class="btn btn-sm btn-primary" data-loading-text="Loading&hellip;">
                                    <i class="fa fa-fw fa-reply"></i> RESTORE
                                </button>
                            </div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        @endif
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
        <div id="deleteUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::auth.users.delete', $user->hashed_id], 'method' => 'DELETE', 'id' => 'deleteUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="deleteUserModalLabel">Delete User</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to <span class="label label-danger">delete</span> this user : <strong>{{ $user->full_name }}</strong> ?</p>
                        </div>
                        <div class="modal-footer">
                            {{ Form::button('Cancel', ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                            <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                                <i class="fa fa-fw fa-trash-o"></i> DELETE
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE MODAL --}}
        <script>
            var $activateUserModal = $('div#activateUserModal'),
                $activateUserForm  = $('form#activateUserForm');

            $('a[href="#activateUserModal"]').on('click', function (e) {
                e.preventDefault();
                $activateUserModal.modal('show');
            });

            $activateUserForm.submit(function (event) {
                event.preventDefault();
                var $submitBtn = $activateUserForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                $.ajax({
                    url:      $activateUserForm.attr('action'),
                    type:     $activateUserForm.attr('method'),
                    dataType: 'json',
                    data:     $activateUserForm.serialize(),
                    success: function(data) {
                        if (data.status === 'success') {
                            $activateUserModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('ERROR ! Check the console !');
                            console.error(data.message);
                            $submitBtn.button('reset');
                        }
                    },
                    error: function(xhr) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(xhr);
                        $submitBtn.button('reset');
                    }
                });

                return false;
            });
        </script>

        {{-- RESTORE MODAL --}}
        @if ($user->trashed())
        <script>
            var $restoreUserModal = $('div#restoreUserModal'),
                $restoreUserForm  = $('form#restoreUserForm');

            $('a[href="#restoreUserModal"]').on('click', function (e) {
                e.preventDefault();
                $restoreUserModal.modal('show');
            });

            $restoreUserForm.on('submit', function (event) {
                event.preventDefault();
                var $submitBtn = $restoreUserForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                $.ajax({
                    url:      $restoreUserForm.attr('action'),
                    type:     $restoreUserForm.attr('method'),
                    dataType: 'json',
                    data:     $restoreUserForm.serialize(),
                    success: function(data) {
                        if (data.status === 'success') {
                            $restoreUserModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('ERROR ! Check the console !');
                            console.error(data.message);
                            $submitBtn.button('reset');
                        }
                    },
                    error: function(xhr) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(xhr);
                        $submitBtn.button('reset');
                    }
                });

                return false;
            });
        </script>
        @endif
    @endcan

    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
        {{-- DELETE MODAL --}}
        <script>
            var $deleteUserModal = $('div#deleteUserModal'),
                $deleteUserForm  = $('form#deleteUserForm');

            $('a[href="#deleteUserModal"]').on('click', function (e) {
                e.preventDefault();
                $deleteUserModal.modal('show');
            });

            $deleteUserForm.on('submit', function (event) {
                event.preventDefault();
                var $submitBtn = $deleteUserForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                $.ajax({
                    url:      $deleteUserForm.attr('action'),
                    type:     $deleteUserForm.attr('method'),
                    dataType: 'json',
                    data:     $deleteUserForm.serialize(),
                    success: function(data) {
                        if (data.status === 'success') {
                            $deleteUserModal.modal('hide');
                            location.replace(
                                "{{ $user->trashed() ? route('admin::auth.users.index') : route('admin::auth.users.show', $user->hashed_id) }}"
                            );
                        }
                        else {
                            alert('ERROR ! Check the console !');
                            console.error(data.message);
                            $submitBtn.button('reset');
                        }
                    },
                    error: function(xhr) {
                        alert('AJAX ERROR ! Check the console !');
                        console.error(xhr);
                        $submitBtn.button('reset');
                    }
                });

                return false;
            });
        </script>
    @endcan
@endsection
