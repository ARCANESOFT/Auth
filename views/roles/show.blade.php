@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-user-tag"></i> @lang("Role's details")
@endsection

<?php /** @var  Arcanesoft\Auth\Models\Role  $role */ ?>

@section('content')
    <div class="row">
        <div class="col-md-5 col-lg-4">
            {{-- ROLE --}}
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header p-2">@lang('Role')</div>
                <table class="table table-borderless table-md mb-0">
                    <tbody>
                        <tr>
                            <th class="text-muted">@lang('Name') :</th>
                            <td class="text-right">{{ $role->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Description') :</th>
                            <td class="text-right">{{ $role->description }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Users') :</th>
                            <td class="text-right">
                                {{ arcanesoft\ui\count_pill($role->users->count()) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Permissions') :</th>
                            <td class="text-right">
                                {{ arcanesoft\ui\count_pill($role->permissions->count()) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Locked') :</th>
                            <td class="text-right">
                                @if ($role->isLocked())
                                    <span class="badge badge-outline-danger">
                                        <i class="fa fa-lock text-danger mr-1"></i> @lang('Locked')
                                    </span>
                                @else
                                    <span class="badge badge-outline-secondary">
                                        <i class="fa fa-unlock text-secondary mr-1"></i> @lang('Unlocked')
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Status') :</th>
                            <td class="text-right">
                                @if ($role->isActive())
                                    <span class="badge badge-outline-success">
                                        <i class="fa fa-check text-success mr-1"></i> @lang('Activated')
                                    </span>
                                @else
                                    <span class="badge badge-outline-secondary">
                                        <i class="fa fa-ban text-secondary mr-1"></i> @lang('Deactivated')
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Created at') :</th>
                            <td class="text-right"><small class="text-muted">{{ $role->created_at }}</small></td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Updated at') :</th>
                            <td class="text-right"><small class="text-muted">{{ $role->updated_at }}</small></td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer text-right p-2">
                    @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('update'), [$role])
                        {{ arcanesoft\ui\action_link('edit', route('admin::auth.roles.edit', [$role]))->size('sm')->setDisabled($role->isLocked()) }}
                    @endcan

                    @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('activate'), [$role])
                        {{ arcanesoft\ui\action_button($role->isActive() ? 'deactivate' : 'activate')->attribute('onclick', "window.Foundation.\$emit('auth::roles.activate')")->size('sm')->setDisabled($role->isLocked()) }}
                    @endcan

                    @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('delete'), [$role])
                        {{ arcanesoft\ui\action_button('delete')->attributeIf($role->isDeletable(), 'onclick', "window.Foundation.\$emit('auth::roles.delete', ".json_encode(['id' => $role->getRouteKey()]).")")->size('sm')->setDisabled($role->isNotDeletable()) }}
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-8">
            {{-- PERMISSIONS --}}
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header">@lang('Permissions')</div>
                <div class="table-responsive">
                    <table id="permissions-table" class="table table-hover table-md mb-0">
                        <thead>
                            <tr>
                                <th>@lang('Group')</th>
                                <th>@lang('Category')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Description')</th>
                                <th class="text-right">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($role->permissions as $permission)
                                <?php /** @var  Arcanesoft\Auth\Models\Permission  $permission */ ?>
                                <tr>
                                    <td>{{ $permission->group->name }}</td>
                                    <td>{{ $permission->category }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td><small>{{ $permission->description }}</small></td>
                                    <td class="text-right">
                                        @can(Arcanesoft\Auth\Policies\PermissionsPolicy::ability('show'))
                                            {{ arcanesoft\ui\action_link_icon('show', route('admin::auth.permissions.show', [$permission]))->size('sm') }}
                                        @endcan

                                        @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('permissions.detach'), [$role, $permission])
                                            <button class="btn btn-sm btn-danger"
                                                    data-toggle="tooltip" data-placement="top" title="@lang('Detach')"
                                                    onclick="window.Foundation.$emit('auth::roles.permissions.detach', {{ json_encode(['id' => $permission->getRouteKey()]) }})">
                                                <i class="fas fa-fw fa-unlink"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">@lang('The list is empty')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- USERS --}}
    <div class="card card-borderless shadow-sm">
        <div class="card-header">@lang('Users')</div>
        <div class="table-responsive">
            <table id="users-table" class="table table-hover table-md mb-0">
                <thead>
                    <tr>
                        <th></th>
                        <th>@lang('First Name')</th>
                        <th>@lang('Last Name')</th>
                        <th>@lang('Email')</th>
                        <th class="text-center">@lang('Created at')</th>
                        <th class="text-center">@lang('Status')</th>
                        <th class="text-right">@lang('Actions')</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($role->users as $user)
                        <?php /** @var Arcanesoft\Auth\Models\User  $user */ ?>
                        <tr>
                            <td>
                                <span class="avatar" title="{{ $user->full_name }}" style="background-image: url({{ $user->avatar }});"></span>
                            </td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-center">{{ $user->created_at }}</td>
                            <td class="text-center">
                                <span class="status {{ $user->isActive() ? 'status-success status-animated' : 'status-secondary' }}" data-toggle="tooltip" data-placement="top" title="{{ $user->isActive() ? __('Activated') : __('Deactivated') }}"></span>
                            </td>
                            <td class="text-right">
                                @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('show'))
                                    {{ arcanesoft\ui\action_link_icon('show', route('admin::auth.users.show', [$user]))->size('sm') }}
                                @endcan

                                @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('users.detach'), [$role, $user])
                                    <button class="btn btn-sm btn-danger"
                                            data-toggle="tooltip" data-placement="top" title="@lang('Detach')"
                                            onclick="window.Foundation.$emit('auth::roles.users.detach', {{ json_encode(['id' => $user->getRouteKey(), 'name' => $user->full_name]) }})">
                                        <i class="fas fa-fw fa-unlink"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">@lang('The list is empty')</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    {{-- ACIVATE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('activate'), [$role])
        <div class="modal modal-danger fade" id="activate-role-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="activateRoleTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.roles.activate', $role], 'method' => 'PUT', 'id' => 'activate-role-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="activateRoleTitle">@lang($role->isActive() ? 'Deactivate Role' : 'Activate Role')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @lang($role->isActive() ? 'Are you sure you want to deactivate role ?' : 'Are you sure you want to activate role ?')
                        </div>
                        <div class="modal-footer justify-content-between">
                            {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                            {{ arcanesoft\ui\action_button($role->isActive() ? 'deactivate' : 'activate')->submit() }}
                        </div>
                    </div>
                {{ form()->close() }}
            </div>
        </div>
    @endcan

    {{-- DELETE MODAL --}}
    @if ($role->isDeletable())
        @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('delete'), [$role])
            <div class="modal modal-danger fade" id="delete-role-modal" data-backdrop="static"
                 tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    {{ form()->open(['route' => ['admin::auth.roles.delete', $role], 'method' => 'DELETE', 'id' => 'delete-role-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelTitleId">@lang('Delete Role')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @lang('Are you sure you want to delete this role ?')
                        </div>
                        <div class="modal-footer justify-content-between">
                            {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                            {{ arcanesoft\ui\action_button('delete')->submit() }}
                        </div>
                    </div>
                    {{ form()->close() }}
                </div>
            </div>
        @endcan
    @endif

    {{-- PERMISSIONS --}}
    @if ($role->permissions->isNotEmpty())
        {{-- DETACH PERMISSION MODAL --}}
        @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('permissions.detach'), [$role])
            <div class="modal modal-danger fade" id="detach-permission-modal" data-backdrop="static"
                 tabindex="-1" role="dialog" aria-labelledby="detach-permission-modal-title" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    {{ form()->open(['route' => ['admin::auth.roles.permissions.detach', $role, ':id'], 'method' => 'DELETE', 'id' => 'detach-permission-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="detach-permission-modal-title">@lang('Detach Permission')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @lang('Are you sure you want to detach permission ?')
                        </div>
                        <div class="modal-footer justify-content-between">
                            {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-fw fa-unlink"></i> @lang('Detach')
                            </button>
                        </div>
                    </div>
                    {{ form()->close() }}
                </div>
            </div>
        @endcan
    @endif

    {{-- USERS --}}
    @if ($role->users->isNotEmpty())
        {{-- DETACH USER MODAL --}}
        @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('users.detach'), [$role])
            <div class="modal modal-danger fade" id="detach-user-modal" data-backdrop="static"
                 tabindex="-1" role="dialog" aria-labelledby="detach-user-modal-title" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    {{ form()->open(['route' => ['admin::auth.roles.users.detach', $role, ':id'], 'method' => 'DELETE', 'id' => 'detach-user-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="detach-user-modal-title">@lang('Detach User')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        </div>
                        <div class="modal-footer justify-content-between">
                            {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-fw fa-unlink"></i> @lang('Detach')
                            </button>
                        </div>
                    </div>
                    {{ form()->close() }}
                </div>
            </div>
        @endcan
    @endif
@endpush

@push('scripts')
    <script>
        window.ready(() => {
            {{-- ACTIVATE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('activate'), [$role])
                let $activateRoleModal = $('div#activate-role-modal'),
                    $activateRoleForm  = $('form#activate-role-form');

                window.Foundation.$on('auth::roles.activate', () => {
                    $activateRoleModal.modal('show');
                });

                $activateRoleForm.on('submit', (event) => {
                    event.preventDefault();

                    let submitBtn = window.Foundation.ui.loadingButton(
                        $activateRoleForm[0].querySelector('button[type="submit"]:not([style*="display: none"])')
                    );
                    submitBtn.loading();

                    window.request().put($activateRoleForm.attr('action'))
                          .then((response) => {
                              if (response.data.code === 'success') {
                                  $activateRoleModal.modal('hide');
                                  location.reload();
                              }
                              else {
                                  alert('ERROR ! Check the console !');
                                  submitBtn.reset();
                              }
                          })
                          .catch((error) => {
                              alert('AJAX ERROR ! Check the console !');
                              submitBtn.reset();
                          });

                    return false;
                });
            @endcan

            {{-- DELETE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('delete'), [$role])
                let $deleteRoleModal = $('div#delete-role-modal'),
                    $deleteRoleForm  = $('form#delete-role-form');

                window.Foundation.$on('auth::roles.delete', () => {
                    $deleteRoleModal.modal('show');
                })

                $deleteRoleForm.on('submit', (event) => {
                    event.preventDefault();

                    let submitBtn = window.Foundation.ui.loadingButton(
                        $deleteRoleForm[0].querySelector('button[type="submit"]')
                    );
                    submitBtn.loading();

                    window.request().delete($deleteRoleForm.attr('action'))
                        .then((response) => {
                            if (response.data.code === 'success') {
                                $deleteRoleModal.modal('hide');
                                location.replace("{{ route('admin::auth.roles.index') }}");
                            }
                            else {
                                alert('ERROR ! Check the console !');
                                submitBtn.button('reset');
                            }
                        })
                        .catch((error) => {
                            alert('AJAX ERROR ! Check the console !');
                            console.log(error);
                            submitBtn.button('reset');
                        });

                    return false;
                });
            @endcan

            {{-- PERMISSIONS --}}
            @if ($role->permissions->isNotEmpty())
                window.plugins.datatable('table#permissions-table', {
                    columns: [
                        { data: 'group'},
                        { data: 'category'},
                        { data: 'name' },
                        { data: 'description'},
                        { data: 'actions', orderable: false, }
                    ],
                });

                {{-- DETACH PERMISSION SCRIPT --}}
                @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('permissions.detach'), [$role])
                    let $detachPermissionModal = $('div#detach-permission-modal'),
                        $detachPermissionForm  = $('form#detach-permission-form'),
                        detachPermissionAction = $detachPermissionForm.attr('action');

                    window.Foundation.$on('auth::roles.permissions.detach', ({id}) => {
                        $detachPermissionForm.attr('action', detachPermissionAction.replace(':id', id));

                        $detachPermissionModal.modal('show');
                    });

                    $detachPermissionForm.on('submit', (event) => {
                        event.preventDefault();

                        let submitBtn = window.Foundation.ui.loadingButton(
                            $detachPermissionForm[0].querySelector('button[type="submit"]:not([style*="display: none"])')
                        );
                        submitBtn.loading();

                        window.request().delete($detachPermissionForm.attr('action'))
                            .then((response) => {
                                if (response.data.code === 'success') {
                                    $detachPermissionModal.modal('hide');
                                    location.reload();
                                }
                                else {
                                    alert('ERROR ! Check the console !');
                                    submitBtn.reset();
                                }
                            })
                            .catch((error) => {
                                alert('AJAX ERROR ! Check the console !');
                                submitBtn.reset();
                            });

                        return false;
                    });

                    $detachPermissionModal.on('hidden.bs.modal', () => {
                        $detachPermissionForm.attr('action', detachPermissionAction);
                    });
                @endcan
            @endif

            {{-- USERS --}}
            @if ($role->users->isNotEmpty())
                window.plugins.datatable('table#users-table', {
                    order: [[1, 'asc']],
                    columns: [
                        { data: 'avatar', orderable: false},
                        { data: 'first_name' },
                        { data: 'last_name' },
                        { data: 'email' },
                        { data: 'created_at'},
                        { data: 'status', orderable: false, },
                        { data: 'actions', orderable: false, }
                    ],
                });

                {{-- DETACH USER SCRIPT --}}
                @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('users.detach'), [$role])
                    let $detachUserModal = $('div#detach-user-modal'),
                        $detachUserForm  = $('form#detach-user-form'),
                        detachUserAction = $detachUserForm.attr('action');

                    window.Foundation.$on('auth::roles.users.detach', ({id, name}) => {
                        $detachUserForm.attr('action', detachUserAction.replace(':id', id));

                        $detachUserModal.find('.modal-body').html("@lang('Are you sure you want to detach user: :name ?')".replace(':name', name))

                        $detachUserModal.modal('show');
                    });

                    $detachUserForm.on('submit', (event) => {
                        event.preventDefault();

                        let submitBtn = window.Foundation.ui.loadingButton(
                            $detachUserForm[0].querySelector('button[type="submit"]:not([style*="display: none"])')
                        );
                        submitBtn.loading();

                        window.request().delete($detachUserForm.attr('action'))
                            .then((response) => {
                                if (response.data.code === 'success') {
                                    $detachUserModal.modal('hide');
                                    location.reload();
                                }
                                else {
                                    alert('ERROR ! Check the console !');
                                    submitBtn.reset();
                                }
                            })
                            .catch((error) => {
                                alert('AJAX ERROR ! Check the console !');
                                submitBtn.reset();
                            });

                        return false;
                    });

                    $detachUserModal.on('hidden.bs.modal', () => {
                        $detachUserForm.attr('action', detachUserAction);
                    });
                @endcan
            @endif
        });
    </script>
@endpush
