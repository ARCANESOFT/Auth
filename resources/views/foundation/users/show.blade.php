@section('header')
    <h1><i class="fa fa-fw fa-users"></i> Users <small>User details</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-5">
            {{-- USER DETAILS --}}
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-blue">
                    <div class="widget-user-image">
                        {{ Html::image($user->gravatar, $user->full_name, ['class' => 'img-circle']) }}
                    </div>
                    <h3 class="widget-user-username">{{ $user->full_name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->since_date }}</h5>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <thead>
                                <tr>
                                    <th>Username :</th>
                                    <td>{{ $user->username }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>First Name :</th>
                                    <td>{{ $user->first_name }}</td>
                                </tr>
                                <tr>
                                    <th>Last Name :</th>
                                    <td>{{ $user->last_name }}</td>
                                </tr>
                                <tr>
                                    <th>Email :</th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($user->isAdmin())
                                            <span class="label label-warning" style="margin-right: 5px;">
                                                <i class="fa fa-fw fa-star"></i> SUPER ADMIN
                                            </span>
                                        @endif

                                        @if ($user->isActive())
                                            <span class="label label-success">Acitve</span>
                                        @else
                                            <span class="label label-default">Disabled</span>
                                        @endif

                                        @if ($user->trashed())
                                            <span class="label label-danger" style="margin-left: 5px;">
                                                <i class="fa fa-fw fa-trash-o"></i> Trashed
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created at :</th>
                                    <td><small>{{ $user->created_at }}</small></td>
                                </tr>
                                <tr>
                                    <th>Updated at :</th>
                                    <td><small>{{ $user->updated_at }}</small></td>
                                </tr>
                                @if ($user->trashed())
                                    <tr>
                                        <th>Deleted at :</th>
                                        <td><small>{{ $user->deleted_at }}</small></td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="box-footer text-right">
                    @can(\Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
                        <a href="{{ route('auth::foundation.users.edit', [$user->hashed_id]) }}" class="btn btn-xs btn-warning">
                            <i class="fa fa-fw fa-pencil"></i> Edit
                        </a>

                        @if ($user->isAdmin())
                            @if ($user->isActive())
                                <a href="javascript:void(0);" class="btn btn-xs btn-inverse" disabled="disabled">
                                    <i class="fa fa-fw fa-power-off"></i> Disable
                                </a>
                            @else
                                <a href="javascript:void(0);" class="btn btn-xs btn-success" disabled="disabled">
                                    <i class="fa fa-fw fa-power-off"></i> Activate
                                </a>
                            @endif
                        @else
                            @if ($user->isActive())
                                <button data-target="#activateUserModal" data-toggle="modal" class="btn btn-xs btn-inverse">
                                    <i class="fa fa-fw fa-power-off"></i> Disable
                                </button>
                            @else
                                <button data-target="#activateUserModal" data-toggle="modal" class="btn btn-xs btn-success">
                                    <i class="fa fa-fw fa-power-off"></i> Activate
                                </button>
                            @endif
                        @endif

                        @if ($user->trashed())
                            <button data-target="#restoreUserModal" data-toggle="modal" class="btn btn-xs btn-primary">
                                <i class="fa fa-fw fa-reply"></i> Restore
                            </button>
                        @endif
                    @endcan

                    @can(\Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
                        @if ($user->isAdmin())
                            <a href="javascript:void(0);" class="btn btn-xs btn-danger" disabled="disabled">
                                <i class="fa fa-fw fa-trash-o"></i> Delete
                            </a>
                        @else
                            <button data-target="#deleteUserModal" data-toggle="modal" class="btn btn-xs btn-danger">
                                <i class="fa fa-fw fa-trash-o"></i> Delete
                            </button>
                        @endif
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            {{-- ROLES --}}
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Roles</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user->roles as $role)
                                <tr>
                                    <td><span class="label label-primary">{{ $role->name }}</span></td>
                                    <td>{{ $role->description }}</td>
                                    <td class="text-right">
                                        @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_SHOW)
                                            <a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                                <i class="fa fa-fw fa-search"></i>
                                            </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE MODAL --}}
        <div id="activateUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['auth::foundation.users.activate', $user->hashed_id], 'method' => 'PUT', 'id' => 'activateUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
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
                                <p>Are you sure you want to <span class="label label-inverse">disable</span> this user : <strong>{{ $user->username }}</strong> ?</p>
                            @else
                                <p>Are you sure you want to <span class="label label-success">activate</span> this user : <strong>{{ $user->username }}</strong> ?</p>
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
                    {{ Form::open(['route' => ['auth::foundation.users.restore', $user->hashed_id], 'method' => 'PUT', 'id' => 'restoreUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <h4 class="modal-title" id="restoreUserModalLabel">Restore User</h4>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to <span class="label label-primary">restore</span> this user : <strong>{{ $user->username }}</strong> ?</p>
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

    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
        {{-- DELETE MODAL --}}
        <div id="deleteUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['route' => ['auth::foundation.users.delete', $user->hashed_id], 'method' => 'DELETE', 'id' => 'deleteUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="deleteUserModalLabel">Delete User</h4>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to <span class="label label-danger">delete</span> this user : <strong>{{ $user->username }}</strong> ?</p>
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

            $restoreUserForm.submit(function (event) {
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

            $deleteUserForm.submit(function (event) {
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
                                "{{ $user->trashed() ? route('auth::foundation.users.index') : route('auth::foundation.users.show', $user->hashed_id) }}"
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
