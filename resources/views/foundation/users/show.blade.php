@section('header')
    <h1><i class="fa fa-fw fa-users"></i> Users <small>User details</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-5">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-blue">
                    <div class="widget-user-image">
                        {!! Html::image($user->gravatar, $user->full_name, ['class' => 'img-circle']) !!}
                    </div>
                    <h3 class="widget-user-username">{{ $user->full_name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->since_date }}</h5>
                </div>
                <div class="box-body">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>First Name</th>
                                <td>{{ $user->first_name }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
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
                                        <span class="label label-success">Disabled</span>
                                    @endif

                                    @if ($user->trashed())
                                        <span class="label label-danger" style="margin-left: 5px;">
                                            <i class="fa fa-fw fa-trash-o"></i> Trashed
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                            @if ($user->trashed())
                                <tr>
                                    <th>Deleted at</th>
                                    <td>{{ $user->deleted_at }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer text-right">
                    <a href="{{ route('auth::foundation.users.edit', [$user->hashed_id]) }}" class="btn btn-xs btn-warning">
                        <i class="fa fa-fw fa-pencil"></i> Edit
                    </a>

                    @if ($user->trashed())
                        <button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#restoreUserModal">
                            <i class="fa fa-fw fa-reply"></i> Restore
                        </button>
                    @endif

                    @if ($user->isAdmin())
                        <a href="javascript:void(0);" class="btn btn-xs btn-danger" disabled="disabled">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </a>
                    @else
                        <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteUserModal">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Roles</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-condensed">
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
                                        <a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                            <i class="fa fa-fw fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS --}}
    <div id="deleteUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel">
        <div class="modal-dialog" role="document">
            {!! Form::open(['route' => ['auth::foundation.users.delete', $user->hashed_id], 'method' => 'DELETE', 'id' => 'deleteUserForm', 'class' => 'form form-loading']) !!}
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
                        <button type="button" class="btn btn-sm btn-default pull-left" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-danger" data-loading-text="Loading&hellip;">
                            <i class="fa fa-fw fa-trash-o"></i> DELETE
                        </button>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    @if ($user->trashed())
        <div id="restoreUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreUserModalLabel">
            <div class="modal-dialog" role="document">
                {!! Form::open(['route' => ['auth::foundation.users.restore', $user->hashed_id], 'method' => 'PUT', 'id' => 'restoreUserForm', 'class' => 'form form-loading']) !!}
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
            redirectUrl     = "{{ $user->trashed() ? route('auth::foundation.users.index') : route('auth::foundation.users.show', $user->hashed_id) }}";

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
                        location.replace(redirectUrl);
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

    @if ($user->trashed())
        <script>
            var restoreUserModal = $('div#restoreUserModal'),
                restoreUserForm  = $('form#restoreUserForm');

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
