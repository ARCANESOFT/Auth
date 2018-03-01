<?php /** @var  Illuminate\Pagination\LengthAwarePaginator  $users */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-users"></i> {{ trans('auth::users.titles.users') }} <small>{{ trans('auth::users.titles.users-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $users])

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin::auth.users.index') }}" class="btn btn-xs btn-default {{ route_is('admin::auth.users.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> {{ trans('core::generals.all') }}
                    </a>
                    <a href="{{ route('admin::auth.users.trash') }}" class="btn btn-xs btn-default {{ route_is('admin::auth.users.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> {{ trans('core::generals.trashed') }}
                    </a>
                </div>

                @unless($trashed)
                <div class="btn-group">
                    <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ trans('auth::roles.titles.roles') }} <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-right">
                        @foreach($rolesFilters as $filterLink)
                            <li>{{ $filterLink }}</li>
                        @endforeach
                    </ul>
                </div>
                @endunless

                @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_CREATE)
                    {{ ui_link_icon('add', route('admin::auth.users.create')) }}
                @endcan
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>{{ trans('auth::users.attributes.username') }}</th>
                            <th>{{ trans('auth::users.attributes.full_name') }}</th>
                            <th>{{ trans('auth::users.attributes.email') }}</th>
                            <th>{{ trans('auth::roles.titles.roles') }}</th>
                            <th class="text-center">{{ trans('auth::users.attributes.last_activity') }}</th>
                            <th class="text-center" style="width: 80px;">{{ trans('core::generals.status') }}</th>
                            <th class="text-right" style="width: 160px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <?php /** @var  Arcanesoft\Auth\Models\User  $user */ ?>
                            <tr>
                                <td class="text-center">
                                    {{ html()->image($user->gravatar, $user->username, ['class' => 'img-circle', 'style' => 'width: 24px;']) }}
                                </td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach($user->roles as $role)
                                        <span class="label label-primary" style="margin-right: 5px;">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <small>{{ $user->formatted_last_activity }}</small>
                                </td>
                                <td class="text-center">
                                    @includeWhen($user->isAdmin(), 'auth::admin.users._includes.super-admin-icon')
                                    {{ label_active_icon($user->isActive()) }}
                                </td>
                                <td class="text-right">
                                    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_SHOW)
                                        {{ ui_link_icon('show', route('admin::auth.users.show', [$user->hashed_id])) }}
                                    @endcan

                                    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
                                        {{ ui_link_icon('edit', route('admin::auth.users.edit', [$user->hashed_id])) }}

                                        @if ($user->trashed())
                                            {{ ui_link_icon('restore', '#restore-user-modal', ['data-user-id' => $user->hashed_id, 'data-user-name' => $user->full_name]) }}
                                        @endif

                                        {{ ui_link_icon($user->isActive() ? 'disable' : 'enable', '#activate-user-modal', ['data-user-id' => $user->hashed_id, 'data-user-name' => $user->full_name, 'data-current-status' => $user->isActive() ? 'enabled' : 'disabled'], $user->isAdmin()) }}
                                    @endcan

                                    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
                                        {{ ui_link_icon('delete', '#delete-user-modal', ['data-user-id' => $user->hashed_id, 'data-user-name' => $user->full_name], ! $user->isDeletable()) }}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <span class="label label-default">{{ trans('auth::users.list-empty') }}</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($users->hasPages())
            <div class="box-footer clearfix">
                {{ $users->render() }}
            </div>
        @endif
    </div>
@endsection

@section('modals')
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE MODAL --}}
        <div id="activate-user-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ form()->open(['method' => 'PUT', 'id' => 'activate-user-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('enable', 'submit')->withLoadingText() }}
                            {{ ui_button('disable', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ form()->close() }}
            </div>
        </div>

        {{-- RESTORE MODAL --}}
        @if ($trashed)
            <div id="restore-user-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    {{ form()->open(['method' => 'PUT', 'id' => 'restore-user-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title">{{ trans('auth::users.modals.restore.title') }}</h4>
                            </div>
                            <div class="modal-body">
                                <p></p>
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
                {{ form()->open(['method' => 'DELETE', 'id' => 'delete-user-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('auth::users.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
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
                    $activateUserForm  = $('form#activate-user-form'),
                    activateUserUrl    = "{{ route('admin::auth.users.activate', [':id']) }}";

                $('a[href="#activate-user-modal"]').on('click', function (event) {
                    event.preventDefault();

                    var that           = $(this),
                        enabled        = that.data('current-status') === 'enabled',
                        enableTitle    = "{!! trans('auth::users.modals.enable.title') !!}",
                        enableMessage  = '{!! trans("auth::users.modals.enable.message") !!}',
                        disableTitle   = "{!! trans('auth::users.modals.disable.title') !!}",
                        disableMessage = '{!! trans("auth::users.modals.disable.message") !!}';

                    $activateUserForm.attr('action', activateUserUrl.replace(':id', that.data('user-id')));
                    $activateUserModal.find('.modal-title').text(enabled ? disableTitle : enableTitle);
                    $activateUserModal.find('.modal-body p').html((enabled ? disableMessage : enableMessage).replace(':name', that.data('user-name')));

                    if (enabled) {
                        $activateUserForm.find('button[type="submit"].btn-success').hide();
                        $activateUserForm.find('button[type="submit"].btn-inverse').show();
                    }
                    else {
                        $activateUserForm.find('button[type="submit"].btn-success').show();
                        $activateUserForm.find('button[type="submit"].btn-inverse').hide();
                    }

                    $activateUserModal.modal('show');
                });

                $activateUserModal.on('hidden.bs.modal', function () {
                    $activateUserForm.attr('action', activateUserUrl);
                    $activateUserModal.find('.modal-title').text('');
                    $activateUserModal.find('.modal-body p').html('');

                    $activateUserForm.find('button[type="submit"]').hide();
                });

                $activateUserForm.on('submit', function (event) {
                    event.preventDefault();

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

        @if ($trashed)
        {{-- RESTORE MODAL --}}
        <script>
            $(function () {
                var $restoreUserModal = $('div#restore-user-modal'),
                    $restoreUserForm  = $('form#restore-user-form'),
                    restoreUserUrl    = "{{ route('admin::auth.users.restore', [':id']) }}";

                $('a[href="#restore-user-modal"]').on('click', function (event) {
                    event.preventDefault();

                    var that = $(this);

                    $restoreUserForm.attr('action', restoreUserUrl.replace(':id', that.data('user-id')));
                    $restoreUserModal.find('.modal-body p').html(
                        '{!! trans("auth::users.modals.restore.message") !!}'.replace(':name', that.data('user-name'))
                    );

                    $restoreUserModal.modal('show');
                });

                $restoreUserModal.on('hidden.bs.modal', function () {
                    $restoreUserForm.attr('action', restoreUserUrl);
                    $restoreUserModal.find('.modal-body p').html('');
                });

                $restoreUserForm.on('submit', function (event) {
                    event.preventDefault();

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
                    $deleteUserForm  = $('form#delete-user-form'),
                    deleteUserUrl    = "{{ route('admin::auth.users.delete', [':id']) }}";

                $('a[href="#delete-user-modal"]').on('click', function (event) {
                    event.preventDefault();

                    var that = $(this);

                    $deleteUserForm.attr('action', deleteUserUrl.replace(':id', that.data('user-id')));
                    $deleteUserModal.find('.modal-body p').html(
                        '{!! trans("auth::users.modals.delete.message") !!}'.replace(':name', that.data('user-name'))
                    );

                    $deleteUserModal.modal('show');
                });

                $deleteUserModal.on('hidden.bs.modal', function () {
                    $deleteUserForm.attr('action', deleteUserUrl);
                    $deleteUserModal.find('.modal-body p').html('');
                });

                $deleteUserForm.on('submit', function (event) {
                    event.preventDefault();

                    var $submitBtn = $deleteUserForm.find('button[type="submit"]');
                        $submitBtn.button('loading');

                    axios.delete($deleteUserForm.attr('action'))
                         .then(function (response) {
                             if (response.data.code === 'success') {
                                 $deleteUserModal.modal('hide');
                                 location.reload();
                             }
                             else {
                                 alert('ERROR ! Check the console !');
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
