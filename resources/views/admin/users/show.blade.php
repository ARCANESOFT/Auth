<?php /** @var  Arcanesoft\Auth\Models\User  $user */ ?>

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
                    @if ($user->canBeImpersonated())
                        <a href="{{ route('admin::auth.users.impersonate', [$user->hashed_id]) }}" class="btn btn-sm btn-default">
                            <i class="fa fa-fw fa-user-secret"></i> Impersonate
                        </a>
                    @endif

                    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
                        {{ ui_link('edit', route('admin::auth.users.edit', [$user->hashed_id])) }}
                        {{ ui_link($user->isActive() ? 'disable' : 'enable', '#activate-user-modal', [], $user->isAdmin()) }}
                        @if ($user->trashed())
                            {{ ui_link('restore', '#restore-user-modal') }}
                        @endif
                    @endcan

                    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
                        {{ ui_link('delete', '#delete-user-modal', [], $user->isAdmin()) }}
                    @endcan
                </div>
            </div>

            {{-- PASSWORD RESET TABLE --}}
            @includeWhen($user->hasPasswordReset(), 'auth::admin.users._includes.password-reset-table', ['passwordReset' => $user->passwordReset])
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
        <div id="activate-user-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.users.activate', $user->hashed_id], 'method' => 'PUT', 'id' => 'activate-user-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="activateUserModalLabel">
                            {{ trans($user->isActive() ? 'auth::users.modals.disable.title' : 'auth::users.modals.enable.title') }}
                        </h4>
                    </div>
                    <div class="modal-body">
                        <p>{!! trans($user->isActive() ? 'auth::users.modals.disable.message' : 'auth::users.modals.enable.message', ['name' => $user->full_name]) !!}</p>
                    </div>
                    <div class="modal-footer">
                        {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                        {{ ui_button($user->isActive() ? 'disable' : 'enable', 'submit')->withLoadingText() }}
                    </div>
                </div>
                {{ form()->close() }}
            </div>
        </div>

        {{-- RESTORE MODAL --}}
        @if ($user->trashed())
            <div id="restore-user-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ form()->open(['route' => ['admin::auth.users.restore', $user->hashed_id], 'method' => 'PUT', 'id' => 'restore-user-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('auth::users.modals.restore.title') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p>{!! trans('auth::users.modals.restore.message', ['name' => $user->full_name]) !!}</p>
                            </div>
                            <div class="modal-footer">
                                {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                                {{ ui_button('restore', 'submit')->withLoadingText() }}
                            </div>
                        </div>
                    {{ form()->close() }}
                </div>
            </div>
        @endif
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
        <div id="delete-user-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.users.delete', $user->hashed_id], 'method' => 'DELETE', 'id' => 'delete-user-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('auth::users.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans('auth::users.modals.delete.message', ['name' => $user->full_name]) !!}</p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('delete', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ form()->close() }}
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE MODAL --}}
        <script>
            $(function () {
                var $activateUserModal = $('div#activate-user-modal'),
                    $activateUserForm  = $('form#activate-user-form');

                $('a[href="#activate-user-modal"]').on('click', function (e) {
                    e.preventDefault();
                    $activateUserModal.modal('show');
                });

                $activateUserForm.on('submit', function (e) {
                    e.preventDefault();

                    var $submitBtn = $activateUserForm.find('button[type="submit"]');
                        $submitBtn.button('loading');

                    axios.put($activateUserForm.attr('action'))
                         .then(function (response) {
                             if (response.data.code === 'success') {
                                 $activateUserModal.modal('hide');
                                 location.reload();
                             }
                             else {
                                 alert('ERROR ! Check the console !');
                                 console.error(response.data.message);
                                 $submitBtn.button('reset');
                             }
                        })
                         .catch(function (error) {
                             alert('AJAX ERROR ! Check the console !');
                             console.log(error);
                             $submitBtn.button('reset');
                         });

                    return false;
                });
            });
        </script>

        {{-- RESTORE MODAL --}}
        @if ($user->trashed())
        <script>
            $(function () {
                var $restoreUserModal = $('div#restore-user-modal'),
                    $restoreUserForm  = $('form#restore-user-form');

                $('a[href="#restore-user-modal"]').on('click', function (e) {
                    e.preventDefault();
                    $restoreUserModal.modal('show');
                });

                $restoreUserForm.on('submit', function (e) {
                    e.preventDefault();

                    var $submitBtn = $restoreUserForm.find('button[type="submit"]');
                        $submitBtn.button('loading');

                    axios.put($restoreUserForm.attr('action'))
                         .then(function (response) {
                             if (response.data.code === 'success') {
                                 $restoreUserModal.modal('hide');
                                 location.reload();
                             }
                             else {
                                 alert('ERROR ! Check the console !');
                                 console.error(response.data.message);
                                 $submitBtn.button('reset');
                             }
                         })
                         .catch(function (error) {
                             alert('AJAX ERROR ! Check the console !');
                             console.log(error);
                             $submitBtn.button('reset');
                         });

                    return false;
                });
            });
        </script>
        @endif
    @endcan

    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
        {{-- DELETE MODAL --}}
        <script>
            $(function () {
                var $deleteUserModal = $('div#delete-user-modal'),
                    $deleteUserForm  = $('form#delete-user-form');

                $('a[href="#delete-user-modal"]').on('click', function (e) {
                    e.preventDefault();
                    $deleteUserModal.modal('show');
                });

                $deleteUserForm.on('submit', function (e) {
                    e.preventDefault();

                    var $submitBtn = $deleteUserForm.find('button[type="submit"]');
                        $submitBtn.button('loading');

                    axios.delete($deleteUserForm.attr('action'))
                         .then(function (response) {
                             if (response.data.code === 'success') {
                                 $deleteUserModal.modal('hide');
                                 location.replace(
                                     "{{ $user->trashed() ? route('admin::auth.users.index') : route('admin::auth.users.show', $user->hashed_id) }}"
                                 );
                             }
                             else {
                                 alert('ERROR ! Check the console !');
                                 console.error(response.data.message);
                                 $submitBtn.button('reset');
                             }
                         })
                         .catch(function (error) {
                             alert('AJAX ERROR ! Check the console !');
                             console.log(error);
                             $submitBtn.button('reset');
                         });

                    return false;
                });
            });
        </script>
    @endcan
@endsection
