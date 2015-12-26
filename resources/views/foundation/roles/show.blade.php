@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> Roles <small>Role details</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">Role details</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $role->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>
                                    <span class="label label-primary">{{ $role->slug }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $role->description }}</td>
                            </tr>
                            <tr>
                                <th>N° Users</th>
                                <td>
                                    <span class="label label-{{ $role->users->count() ? 'info' : 'default' }}">
                                        {{ $role->users->count() }} Users
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>N° Permissions</th>
                                <td>
                                    <span class="label label-{{ $role->permissions->count() ? 'info' : 'default' }}">
                                        {{ $role->permissions->count() }} Permissions
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="label label-{{ $role->isActive() ? 'success' : 'default'}}">
                                        <i class="fa fa-fw fa-{{ $role->isActive() ? 'check' : 'ban-o'}}"></i>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Locked</th>
                                <td>
                                    <span class="label label-{{ $role->isLocked() ? 'danger' : 'success'}}">
                                        <i class="fa fa-fw fa-{{ $role->isLocked() ? 'lock' : 'unlock'}}"></i>
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>
                                    <small>{{ $role->created_at }}</small>
                                </td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>
                                    <small>{{ $role->updated_at }}</small>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-right">
                    @if ($role->isLocked())
                        <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled">
                            <i class="fa fa-fw fa-pencil"></i> Update
                        </a>
                        <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </a>
                    @else
                        <a href="{{ route('auth::foundation.roles.edit', [$role->hashed_id]) }}" class="btn btn-xs btn-warning">
                            <i class="fa fa-fw fa-pencil"></i> Update
                        </a>
                        <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteRoleModal">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#users" data-toggle="tab" aria-expanded="true">Users</a>
                    </li>
                    <li>
                        <a href="#permissions" data-toggle="tab" aria-expanded="true">Permissions</a>
                    </li>
                </ul>
                <div class="tab-content no-padding">
                    <div id="users" class="tab-pane active">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th style="width: 40px;"></th>
                                    <th>Username</th>
                                    <th>Full name</th>
                                    <th>Email</th>
                                    <th class="text-center" style="width: 80px;">Status</th>
                                    <th class="text-right" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($role->users->count())
                                    @foreach ($role->users as $user)
                                        <tr>
                                            <td class="text-center">
                                                {!! Html::image($user->gravatar, $user->username, ['class' => 'img-circle', 'style' => 'width: 24px;']) !!}
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
                                                    <span class="label label-success">
                                                        <i class="fa fa-check"></i>
                                                    </span>
                                                @else
                                                    <span class="label label-default">
                                                        <i class="fa fa-ban"></i>
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('auth::foundation.users.show', [$user->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                                    <i class="fa fa-fw fa-search"></i>
                                                </a>
                                                <a href="{{ route('auth::foundation.users.edit', [$user->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                                    <i class="fa fa-fw fa-pencil"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            <span class="label label-default">No user has this role.</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div id="permissions" class="tab-pane no-padding">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Group</th>
                                    <th>Slug</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-right" style="width: 80px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($role->permissions->count())
                                    @foreach ($role->permissions->sortByDesc('group_id') as $permission)
                                        <tr>
                                            <td>
                                                <span class="label label-{{ $permission->hasGroup() ? 'primary' : 'default' }}">
                                                    {{ $permission->hasGroup() ? $permission->group->name : 'Custom' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="label label-success">{{ $permission->slug }}</span>
                                            </td>
                                            <td>{{ $permission->name }}</td>
                                            <td>{{ $permission->description }}</td>
                                            <td class="text-right">
                                                <a href="{{ route('auth::foundation.permissions.show', [$permission->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                                    <i class="fa fa-fw fa-search"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <span class="label label-default">No permission belongs to this role.</span>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS --}}
    <div id="deleteRoleModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => ['auth::foundation.roles.delete', $role->hashed_id], 'method' => 'DELETE', 'id' => 'deleteRoleForm', 'class' => 'form form-loading']) !!}
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
                        <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                            <i class="fa fa-fw fa-trash-o"></i> DELETE
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        var deleteRoleModal = $('div#deleteRoleModal'),
            deleteRoleForm  = $('form#deleteRoleForm');

        deleteRoleForm.submit(function (event) {
            event.preventDefault();
            var submitBtn = $(this).find('button[type="submit"]');
                submitBtn.button('loading');

            $.ajax({
                url:      $(this).attr('action'),
                type:     $(this).attr('method'),
                dataType: 'json',
                data:     $(this).serialize(),
                success: function(data) {
                    if (data.status === 'success') {
                        deleteRoleModal.modal('hide');
                        location.replace("{{ route('auth::foundation.roles.index') }}");
                    }
                    else {
                        alert('ERROR ! Check the console !');
                        console.error(data.message);
                        submitBtn.button('reset');
                    }
                },
                error: function(xhr) {
                    alert('AJAX ERROR ! Check the console !');
                    console.error(xhr);
                    submitBtn.button('reset');
                }
            });

            return false;
        });
    </script>
@endsection
