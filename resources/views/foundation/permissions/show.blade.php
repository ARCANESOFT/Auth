@section('header')
    <h1><i class="fa fa-fw fa-check-circle"></i> Permissions <small>Permission details</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-12 col-md-5">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Permission details</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td><span class="label label-success">{{ $permission->slug }}</span></td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $permission->description }}</td>
                            </tr>
                            <tr>
                                <th>N° Roles</th>
                                <td>
                                    <span class="label label-{{ $permission->roles->count() ? 'info' : 'default'}}">
                                        {{ $permission->roles->count() }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td><small>{{ $permission->created_at }}</small></td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td><small>{{ $permission->updated_at }}</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($permission->hasGroup())
                <?php
                    /** @var  \Arcanesoft\Auth\Models\PermissionsGroup  $group */
                    $group = $permission->group->load('permissions');
                ?>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Permissions Group</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td><span class="label label-primary">{{ $group->name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Slug</th>
                                    <td><span class="label label-primary">{{ $group->slug }}</span></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $group->description }}</td>
                                </tr>
                                <tr>
                                    <th>N° Permissions</th>
                                    <td>
                                    <span class="label label-{{ $group->permissions->count() ? 'info' : 'default'}}">
                                        {{ $group->permissions->count() }}
                                    </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Created at</th>
                                    <td><small>{{ $group->created_at }}</small></td>
                                </tr>
                                <tr>
                                    <th>Updated at</th>
                                    <td><small>{{ $group->updated_at }}</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        {!! link_to_route('auth::foundation.permissions.group', 'Show all permissions', [$group->hashed_id], ['class' => 'btn btn-sm btn-default btn-block']) !!}
                    </div>
                </div>
            @else
                <div class="box box-default">
                    <div class="box-header">
                        <h3 class="box-title">Permissions Group</h3>
                    </div>
                    <div class="box-body no-padding">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th>Name</th>
                                    <td><span class="label label-default">Custom</span></td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>This permission isn't belonging to any group of permissions.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="box-footer">
                        {!! link_to_route('auth::foundation.permissions.group', 'Show all permissions', [hasher()->encode(0)], ['class' => 'btn btn-sm btn-default btn-block']) !!}
                    </div>
                </div>
            @endif
        </div>
        <div class="col-sm-12 col-md-7">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Roles</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-center">N° Users</th>
                                <th class="text-right" style="width: 75px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permission->roles as $role)
                                <tr>
                                    <td>
                                        <span class="label label-primary">{{ $role->name }}</span>
                                    </td>
                                    <td>{{ $role->description }}</td>
                                    <td class="text-center">
                                        <span class="label label-{{ $role->users->count() ? 'info' : 'default'}}">
                                            {{ $role->users->count() }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                            <i class="fa fa-fw fa-search"></i>
                                        </a>
                                        @if ($role->isLocked())
                                            <a href="javascript:void(0);" class="btn btn-xs btn-default" data-toggle="tooltip" data-original-title="Detach" disabled="disabled">
                                                <i class="fa fa-fw fa-chain-broken"></i>
                                            </a>
                                        @else
                                            <a href="#detachRoleModal" class="btn btn-xs btn-danger" data-toggle="tooltip" data-original-title="Detach" data-role-id="{{ $role->hashed_id }}" data-role-name="{{ $role->name }}">
                                                <i class="fa fa-fw fa-chain-broken"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div id="detachRoleModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="detachRoleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'DELETE', 'id' => 'detachRoleForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="detachRoleModalLabel">Detach Role</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                            <i class="fa fa-fw fa-chain-broken"></i> DETACH
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection

@section('scripts')
    {{-- DETACH SCRIPT --}}
    <script>
        var detachRoleModal = $('div#detachRoleModal'),
            detachRoleForm  = $('form#detachRoleForm'),
            detachRoleUrl   = "{{ route('auth::foundation.permissions.roles.detach', [$permission->hashed_id, ':id']) }}";

        $('a[href="#detachRoleModal"]').click(function (event) {
            event.preventDefault();
            var modalMessage = 'Are you sure you want to <span class="label label-danger">detach</span> this role : <strong>:role</strong> ?';

            detachRoleForm.attr('action', detachRoleUrl.replace(':id', $(this).data('role-id')));
            detachRoleModal.find('.modal-body p').html(modalMessage.replace(':role', $(this).data('role-name')));

            detachRoleModal.modal('show');
        });

        detachRoleModal.on('hidden.bs.modal', function () {
            detachRoleForm.removeAttr('action');
            $(this).find('.modal-body p').html('');
        });

        detachRoleForm.submit(function (event) {
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
                        detachRoleModal.modal('hide');
                        location.reload();
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
