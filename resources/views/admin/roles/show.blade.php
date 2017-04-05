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
                                    <td>
                                        <span class="label label-{{ $role->users->count() ? 'info' : 'default' }}">
                                            {{ $role->users->count() }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::permissions.titles.permissions') }} :</th>
                                    <td>
                                        <span class="label label-{{ $role->permissions->count() ? 'info' : 'default' }}">
                                            {{ $role->permissions->count() }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.status') }} :</th>
                                    <td>
                                        @if ($role->isActive())
                                            <span class="label label-success"><i class="fa fa-fw fa-check"></i></span>
                                        @else
                                            <span class="label label-default"><i class="fa fa-fw fa-ban"></i></span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::roles.attributes.locked') }} :</th>
                                    <td>
                                        @if ($role->isLocked())
                                            <span class="label label-danger"><i class="fa fa-fw fa-lock"></i></span>
                                        @else
                                            <span class="label label-success"><i class="fa fa-fw fa-unlock"></i></span>
                                        @endif
                                    </td>
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
                    @if ($role->isLocked())
                        @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
                            <a href="javascript:void(0);" class="btn btn-sm btn-warning" disabled="disabled">
                                <i class="fa fa-fw fa-pencil"></i> Update
                            </a>

                            @if ($role->isActive())
                                <a href="javascript:void(0);" class="btn btn-sm btn-inverse" disabled="disabled">
                                    <i class="fa fa-fw fa-power-off"></i> Disable
                                </a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-sm btn-success" disabled="disabled">
                                    <i class="fa fa-fw fa-power-off"></i> Activate
                                </a>
                            @endif
                        @endcan

                        @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
                            <a href="javascript:void(0);" class="btn btn-sm btn-danger" disabled="disabled">
                                <i class="fa fa-fw fa-trash-o"></i> Delete
                            </a>
                        @endcan
                    @else
                        @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
                            <a href="{{ route('admin::auth.roles.edit', [$role->hashed_id]) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-fw fa-pencil"></i> Update
                            </a>
                            @if ($role->isActive())
                                <button data-target="#activateRoleModal" data-toggle="modal" class="btn btn-sm btn-inverse">
                                    <i class="fa fa-fw fa-power-off"></i> Disable
                                </button>
                            @else
                                <button data-target="#activateRoleModal" data-toggle="modal" class="btn btn-sm btn-success">
                                    <i class="fa fa-fw fa-power-off"></i> Activate
                                </button>
                            @endif
                        @endcan

                        @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
                            <button data-target="#deleteRoleModal" data-toggle="modal" class="btn btn-sm btn-danger">
                                <i class="fa fa-fw fa-trash-o"></i> Delete
                            </button>
                        @endcan
                    @endif
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
                                                @if ($user->isAdmin())
                                                    <span class="label label-warning" data-toggle="tooltip" data-original-title="SUPER ADMIN" style="margin-right: 5px;">
                                                    <i class="fa fa-fw fa-star"></i>
                                                </span>
                                                @endif
                                                @if ($user->isActive())
                                                    <span class="label label-success"><i class="fa fa-check"></i></span>
                                                @else
                                                    <span class="label label-default"><i class="fa fa-ban"></i></span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                @can('auth.users.show')
                                                    <a href="{{ route('admin::auth.users.show', [$user->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                                        <i class="fa fa-fw fa-search"></i>
                                                    </a>
                                                @endcan
                                                @can('auth.users.update')
                                                    <a href="{{ route('admin::auth.users.edit', [$user->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                                        <i class="fa fa-fw fa-pencil"></i>
                                                    </a>
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
                                                        <a href="{{ route('admin::auth.permissions.show', [$permission->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                                            <i class="fa fa-fw fa-search"></i>
                                                        </a>
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
                                {{ $role->isActive() ? 'Disable Role' : 'Activate Role' }}
                            </h4>
                        </div>
                        <div class="modal-body">
                            @if ($role->isActive())
                                <p>Are you sure you want to <span class="label label-inverse">disable</span> this role : <strong>{{ $role->name }}</strong> ?</p>
                            @else
                                <p>Are you sure you want to <span class="label label-success">activate</span> this role : <strong>{{ $role->name }}</strong> ?</p>
                            @endif
                        </div>
                        <div class="modal-footer">
                            {{ Form::button('Cancel', ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                            @if ($role->isActive())
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
                            <h4 class="modal-title" id="deleteRoleModalLabel">Delete Role</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to <span class="label label-danger">delete</span> this role : <strong>{{ $role->name }}</strong> ?</p>
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
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE MODAL --}}
        <script>
            $(function() {
                var $activateRoleModal = $('div#activateRoleModal'),
                    $activateRoleForm  = $('form#activateRoleForm');

                $activateRoleForm.on('submit', function (event) {
                    event.preventDefault();

                    var $submitBtn = $activateRoleForm.find('button[type="submit"]');
                        $submitBtn.button('loading');

                    $.ajax({
                        url:      $activateRoleForm.attr('action'),
                        type:     $activateRoleForm.attr('method'),
                        dataType: 'json',
                        data:     $activateRoleForm.serialize(),
                        success: function(data) {
                            if (data.status === 'success') {
                                $activateRoleModal.modal('hide');
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
            });
        </script>
    @endcan

    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
        <script>
            {{-- DELETE MODAL --}}
            $(function () {
                var $deleteRoleModal = $('div#deleteRoleModal'),
                    $deleteRoleForm  = $('form#deleteRoleForm');

                $deleteRoleForm.on('submit', function (event) {
                    event.preventDefault();

                    var $submitBtn = $deleteRoleForm.find('button[type="submit"]');
                        $submitBtn.button('loading');

                    $.ajax({
                        url:      $deleteRoleForm.attr('action'),
                        type:     $deleteRoleForm.attr('method'),
                        dataType: 'json',
                        data:     $deleteRoleForm.serialize(),
                        success: function(data) {
                            if (data.status === 'success') {
                                $deleteRoleModal.modal('hide');
                                location.replace("{{ route('admin::auth.roles.index') }}");
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
            });
        </script>
    @endcan
@endsection
