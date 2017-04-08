<?php /** @var  \Arcanesoft\Auth\Models\Role  $role */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> {{ trans('auth::roles.titles.roles') }} <small>{{ trans('auth::roles.titles.role-details') }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{-- ROLE DETAILS --}}
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('auth::roles.titles.role-details') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                                <tr>
                                    <th>{{ trans('auth::roles.attributes.name') }} :</th>
                                    <td>{{ $role->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::roles.attributes.slug') }} :</th>
                                    <td>
                                        <span class="label label-primary">{{ $role->slug }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::roles.attributes.description') }} :</th>
                                    <td>{{ $role->description }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::users.titles.users') }} :</th>
                                    <td>{{ label_count($role->users->count()) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::permissions.titles.permissions') }} :</th>
                                    <td>{{ label_count($role->permissions->count()) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.status') }} :</th>
                                    <td>{{ label_active_status($role->isActive()) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::roles.attributes.locked') }} :</th>
                                    <td>{{ label_locked_status($role->isLocked()) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.created_at') }} :</th>
                                    <td><small>{{ $role->created_at }}</small></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.updated_at') }} :</th>
                                    <td><small>{{ $role->updated_at }}</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
                        @include('core::admin._includes.actions.links.edit', $role->isLocked() ? ['disabled' => true] : ['url' => route('admin::auth.roles.edit', [$role->hashed_id])])
                        @includeWhen($role->isActive(), 'core::admin._includes.actions.links.disable', $role->isLocked() ? ['disabled' => true] : ['url' => '#activateRoleModal'])
                        @includeWhen( ! $role->isActive(), 'core::admin._includes.actions.links.enable', $role->isLocked() ? ['disabled' => true] : ['url' => '#activateRoleModal'])
                    @endcan

                    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
                        @include('core::admin._includes.actions.links.delete', $role->isLocked() ? ['disabled' => true] : ['url' => '#deleteRoleModal'])
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-md-8">
            {{-- TABS --}}
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#users" data-toggle="tab" aria-expanded="true">{{ trans('auth::users.titles.users') }}</a>
                    </li>
                    <li>
                        <a href="#permissions" data-toggle="tab" aria-expanded="true">{{ trans('auth::permissions.titles.permissions') }}</a>
                    </li>
                </ul>
                <div class="tab-content no-padding">
                    {{-- USERS --}}
                    <div id="users" class="tab-pane active">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover no-margin">
                                <thead>
                                    <tr>
                                        <th style="width: 40px;"></th>
                                        <th>{{ trans('auth::users.attributes.username') }}</th>
                                        <th>{{ trans('auth::users.attributes.full_name') }}</th>
                                        <th>{{ trans('auth::users.attributes.email') }}</th>
                                        <th class="text-center" style="width: 80px;">{{ trans('core::generals.status') }}</th>
                                        <th class="text-right" style="width: 120px;">{{ trans('core::generals.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($role->users->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">
                                                <span class="label label-default">{{ trans('auth::roles.has-no-users') }}</span>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($role->users as $user)
                                        <?php /** @var  \Arcanesoft\Auth\Models\User  $user */ ?>
                                        <tr>
                                            <td class="text-center">
                                                {{ html()->image($user->gravatar, $user->username, ['class' => 'img-circle', 'style' => 'width: 24px;']) }}
                                            </td>
                                            <td>{{ $user->username }}</td>
                                            <td>{{ $user->full_name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td class="text-center">
                                                @includeWhen($user->isAdmin(), 'auth::admin.users._includes.super-admin-icon')
                                                {{ label_active_icon($user->isActive()) }}
                                            </td>
                                            <td class="text-right">
                                                @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_SHOW)
                                                    @include('core::admin._includes.actions.icon-links.show', ['url' => route('admin::auth.users.show', [$user->hashed_id])])
                                                @endcan

                                                @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
                                                    @include('core::admin._includes.actions.icon-links.edit', $user->isAdmin() ? ['disabled' => true] : ['url' => route('admin::auth.users.edit', [$user->hashed_id])])
                                                @endcan
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- PERMISSIONS --}}
                    <div id="permissions" class="tab-pane no-padding">
                        <div class="table-responsive">
                            <table class="table table-condensed table-hover no-margin">
                                <thead>
                                    <tr>
                                        <th>{{ trans('auth::permissions.attributes.group') }}</th>
                                        <th>{{ trans('auth::permissions.attributes.slug') }}</th>
                                        <th>{{ trans('auth::permissions.attributes.name') }}</th>
                                        <th>{{ trans('auth::permissions.attributes.description') }}</th>
                                        <th class="text-right" style="width: 80px;">{{ trans('core::generals.actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($role->permissions->isEmpty())
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <span class="label label-default">{{ trans('auth::roles.has-no-permissions') }}</span>
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($role->permissions->sortByDesc('group_id') as $permission)
                                            <?php /** @var  \Arcanesoft\Auth\Models\Permission  $permission */ ?>
                                            <tr>
                                                <td>
                                                    @if ($permission->hasGroup())
                                                        <span class="label label-primary">{{ $permission->group->name }}</span>
                                                    @else
                                                        <span class="label label-default">{{ trans('auth::permission-groups.custom') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="label label-success">{{ $permission->slug }}</span>
                                                </td>
                                                <td>{{ $permission->name }}</td>
                                                <td>{{ $permission->description }}</td>
                                                <td class="text-right">
                                                    @can(Arcanesoft\Auth\Policies\PermissionsPolicy::PERMISSION_SHOW)
                                                        @include('core::admin._includes.actions.icon-links.show', ['url' => route('admin::auth.permissions.show', [$permission->hashed_id])])
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    {{-- ACTIVATE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
        <div id="activateRoleModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="activateRoleModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::auth.roles.activate', $role->hashed_id], 'method' => 'PUT', 'id' => 'activateRoleForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="activateRoleModalLabel">
                                {{ trans($role->isActive() ? 'auth::roles.modals.disable.title' : 'auth::roles.modals.enable.title') }}
                            </h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans($role->isActive() ? 'auth::roles.modals.disable.message' : 'auth::roles.modals.enable.message', ['name' => $role->name]) !!}</p>
                        </div>
                        <div class="modal-footer">
                            {{ Form::button(ucfirst(trans('core::actions.cancel')), ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                            <button type="submit" class="btn btn-sm btn-{{ $role->isActive() ? 'inverse' : 'success' }}" data-loading-text="{{ trans('core::generals.loading') }}">
                                <i class="fa fa-fw fa-power-off"></i> {{ ucfirst(trans($role->isActive() ? 'core::actions.disable' : 'core::actions.enable')) }}
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
        <div id="deleteRoleModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['admin::auth.roles.delete', $role->hashed_id], 'method' => 'DELETE', 'id' => 'deleteRoleForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="deleteRoleModalLabel">{{ trans('auth::roles.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p>{!! trans('auth::roles.modals.delete.message', ['name' => $role->name]) !!}</p>
                        </div>
                        <div class="modal-footer">
                            {{ Form::button(ucfirst(trans('core::actions.cancel')), ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                            <button type="submit" class="btn btn-sm btn-danger" data-loading-text="{{ trans('core::generals.loading') }}">
                                <i class="fa fa-fw fa-trash-o"></i> {{ ucfirst(trans('core::actions.delete')) }}
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    {{-- ACTIVATE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
    <script>
        $(function() {
            var $activateRoleModal = $('div#activateRoleModal'),
                $activateRoleForm  = $('form#activateRoleForm');

            $('a[href="#activateRoleModal"]').on('click', function (e) {
                e.preventDefault();
                $activateRoleModal.modal('show');
            });

            $activateRoleForm.on('submit', function (event) {
                event.preventDefault();

                var $submitBtn = $activateRoleForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                axios.put($activateRoleForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $activateRoleModal.modal('hide');
                             location.reload();
                         }
                         else {
                             alert('ERROR ! Check the console !');
                             console.error(data.message);
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

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
    <script>
        $(function () {
            var $deleteRoleModal = $('div#deleteRoleModal'),
                $deleteRoleForm  = $('form#deleteRoleForm');

            $('a[href="#deleteRoleModal"]').on('click', function (e) {
                e.preventDefault();
                $deleteRoleModal.modal('show');
            });

            $deleteRoleForm.on('submit', function (event) {
                event.preventDefault();

                var $submitBtn = $deleteRoleForm.find('button[type="submit"]');
                    $submitBtn.button('loading');

                axios.delete($deleteRoleForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $deleteRoleModal.modal('hide');
                             location.replace("{{ route('admin::auth.roles.index') }}");
                         }
                         else {
                             alert('ERROR ! Check the console !');
                             console.error(data.message);
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
