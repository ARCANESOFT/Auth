@section('header')
    <h1><i class="fa fa-fw fa-users"></i> Users <small>List of users</small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <span class="label label-info" style="margin-right: 5px;">
                Total of users : {{ $users->total() }}
            </span>

            @if ($users->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $users->currentPage(), 'last' => $users->lastPage()]) }}
                </span>
            @endif

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('auth::foundation.users.index') }}" class="btn btn-xs btn-default {{ route_is('auth::foundation.users.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> All
                    </a>
                    <a href="{{ route('auth::foundation.users.trash') }}" class="btn btn-xs btn-default {{ route_is('auth::foundation.users.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> Trashed
                    </a>
                </div>

                <a href="{{ route('auth::foundation.users.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Username</th>
                            <th>Full name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th class="text-center" style="width: 80px;">Status</th>
                            <th class="text-right" style="width: 130px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->count())
                            @foreach($users as $user)
                                <tr>
                                    <td class="text-center">
                                        {!! Html::image($user->gravatar, $user->username, ['class' => 'img-circle', 'style' => 'width: 24px;']) !!}
                                    </td>
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->full_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="label label-primary" style="margin-right: 5px;">{{  $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td class="text-center">
                                        @if ($user->isAdmin())
                                            <span class="label label-warning" data-toggle="tooltip" data-original-title="SUPER ADMIN" style="margin-right: 5px;"><i class="fa fa-fw fa-star"></i></span>
                                        @endif

                                        @if ($user->isActive())
                                            <span class="label label-success"><i class="fa fa-check"></i></span>
                                        @else
                                            <span class="label label-default"><i class="fa fa-ban"></i></span>
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('auth::foundation.users.show', [$user->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                            <i class="fa fa-fw fa-search"></i>
                                        </a>

                                        <a href="{{ route('auth::foundation.users.edit', [$user->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                            <i class="fa fa-fw fa-pencil"></i>
                                        </a>

                                        @if ($user->trashed())
                                            <a href="#restoreUserModal" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Restore" data-user-id="{{ $user->hashed_id }}" data-user-name="{{ $user->username }}">
                                                <i class="fa fa-fw fa-reply"></i>
                                            </a>
                                        @endif

                                        @if ($user->isAdmin())
                                            <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled"  data-toggle="tooltip" data-original-title="Delete">
                                                <i class="fa fa-fw fa-trash-o"></i>
                                            </a>
                                        @else
                                            <a href="#deleteUserModal" class="btn btn-xs btn-danger" data-toggle="tooltip" data-original-title="Delete" data-user-id="{{ $user->hashed_id }}" data-user-name="{{ $user->username }}">
                                                <i class="fa fa-fw fa-trash-o"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="text-center">
                                    <span class="label label-default">The list of users is empty.</span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ($users->hasPages())
            <div class="box-footer clearfix">{!! $users->render() !!}</div>
        @endif
    </div>

    {{-- MODALS --}}
    <div id="deleteUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['method' => 'DELETE', 'id' => 'deleteUserForm', 'class' => 'form form-loading']) !!}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteUserModalLabel">Delete User</h4>
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

    @if ($trashed)
        <div id="restoreUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreUserModalLabel">
            <div class="modal-dialog" role="document">
                {!! Form::open(['method' => 'PUT', 'id' => 'restoreUserForm', 'class' => 'form form-loading']) !!}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="restoreUserModalLabel">Restore User</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-primary" data-loading-text="Loading&hellip;">
                                <i class="fa fa-fw fa-reply"></i> RESTORE
                            </button>
                        </div>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <script>
        var deleteUserModal = $('div#deleteUserModal'),
            deleteUserForm  = $('form#deleteUserForm'),
            deleteUserUrl   = "{{ route('auth::foundation.users.delete', [':id']) }}";

        $('a[href="#deleteUserModal"]').click(function (event) {
            event.preventDefault();
            var modalMessage = 'Are you sure you want to <span class="label label-danger">delete</span> this user : <strong>:username</strong> ?';

            deleteUserForm.attr('action', deleteUserUrl.replace(':id', $(this).data('user-id')));
            deleteUserModal.find('.modal-body p').html(modalMessage.replace(':username', $(this).data('user-name')));

            deleteUserModal.modal('show');
        });

        deleteUserModal.on('hidden.bs.modal', function () {
            deleteUserForm.removeAttr('action');
            $(this).find('.modal-body p').html('');
        });

        deleteUserForm.submit(function (event) {
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
                        deleteUserModal.modal('hide');
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

    @if ($trashed)
        <script>
            var restoreUserModal = $('div#restoreUserModal'),
                restoreUserForm  = $('form#restoreUserForm'),
                restoreUserUrl   = "{{ route('auth::foundation.users.restore', [':id']) }}";

            $('a[href="#restoreUserModal"]').click(function (event) {
                event.preventDefault();
                var modalMessage = 'Are you sure you want to <span class="label label-primary">restore</span> this user : <strong>:username</strong> ?';

                restoreUserForm.attr('action', restoreUserUrl.replace(':id', $(this).data('user-id')));
                restoreUserModal.find('.modal-body p').html(modalMessage.replace(':username', $(this).data('user-name')));

                restoreUserModal.modal('show');
            });

            restoreUserModal.on('hidden.bs.modal', function () {
                restoreUserForm.removeAttr('action');
                $(this).find('.modal-body p').html('');
            });

            restoreUserForm.submit(function (event) {
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
                            restoreUserModal.modal('hide');
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
    @endif
@endsection
