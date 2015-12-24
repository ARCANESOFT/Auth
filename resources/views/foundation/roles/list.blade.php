@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> Roles <small>List of roles</small></h1>
@endsection

@section('content')
    <div class="box box-warning">
        <div class="box-header">
            <span class="label label-info" style="margin-right: 5px;">
                Total of roles : {{ $roles->total() }}
            </span>
            @if ($roles->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $roles->currentPage(), 'last' => $roles->lastPage()]) }}
                </span>
            @endif

            <div class="box-tools">
                <a href="{{ route('auth::foundation.roles.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th class="text-center">N° Users</th>
                        <th class="text-center">N° Permissions</th>
                        <th class="text-center" style="width: 60px;">Status</th>
                        <th class="text-center" style="width: 60px;">Locked</th>
                        <th class="text-right" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <span class="label label-primary">{{ $role->slug }}</span>
                            </td>
                            <td>{{ $role->description }}</td>
                            <td class="text-center">
                                <span class="label label-{{ $role->users->count() ? 'info' : 'default' }}">
                                    {{ $role->users->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="label label-{{ $role->permissions->count() ? 'info' : 'default' }}">
                                    {{ $role->permissions->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="label label-{{ $role->isActive() ? 'success' : 'default'}}">
                                    <i class="fa fa-fw fa-{{ $role->isActive() ? 'check' : 'ban-o'}}"></i>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="label label-{{ $role->isLocked() ? 'danger' : 'success'}}">
                                    <i class="fa fa-fw fa-{{ $role->isLocked() ? 'lock' : 'unlock'}}"></i>
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                    <i class="fa fa-fw fa-search"></i>
                                </a>
                                @if ($role->isLocked())
                                    <a href="javascript:void(0);" class="btn btn-xs btn-warning" disabled="disabled" data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fa fa-fw fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-xs btn-danger" disabled="disabled" data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                @else
                                    <a href="{{ route('auth::foundation.roles.edit', [$role->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fa fa-fw fa-pencil"></i>
                                    </a>
                                    <a href="#deleteRoleModal" class="btn btn-xs btn-danger" data-toggle="tooltip" data-original-title="Delete" data-role-id="{{ $role->hashed_id }}" data-role-name="{{ $role->name }}">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($roles->hasPages())
            <div class="box-footer clearfix">
                {!! $roles->render() !!}
            </div>
        @endif
    </div>

    {{-- MODALS --}}
    <div id="deleteRoleModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'DELETE', 'id' => 'deleteRoleForm', 'class' => 'form form-loading']) !!}
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="deleteRoleModalLabel">Delete Role</h4>
                    </div>
                    <div class="modal-body">
                        <p></p>
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
            deleteRoleForm  = $('form#deleteRoleForm'),
            deleteRoleUrl   = "{{ route('auth::foundation.roles.delete', [':id']) }}";

        $('a[href="#deleteRoleModal"]').click(function (event) {
            event.preventDefault();
            var modalMessage = 'Are you sure you want to <span class="label label-danger">delete</span> this role : <strong>:role</strong> ?';

            deleteRoleForm.attr('action', deleteRoleUrl.replace(':id', $(this).data('role-id')));
            deleteRoleModal.find('.modal-body p').html(modalMessage.replace(':role', $(this).data('role-name')));

            deleteRoleModal.modal('show');
        });

        deleteRoleModal.on('hidden.bs.modal', function () {
            deleteRoleForm.removeAttr('action');
            $(this).find('.modal-body p').html('');
        });

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
