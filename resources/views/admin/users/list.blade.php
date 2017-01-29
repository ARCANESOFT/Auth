@section('header')
    <h1><i class="fa fa-fw fa-users"></i> Users <small>List of users</small></h1>
@endsection

@section('content')
    <div class="box box-primary">
        <div class="box-header with-border">
            <span class="label label-info" style="margin-right: 5px;">
                Total : {{ $users->total() }}
            </span>

            @if ($users->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $users->currentPage(), 'last' => $users->lastPage()]) }}
                </span>
            @endif

            <div class="box-tools">
                <div class="btn-group" role="group">
                    <a href="{{ route('admin::auth.users.index') }}" class="btn btn-xs btn-default {{ route_is('admin::auth.users.index') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-bars"></i> All
                    </a>
                    <a href="{{ route('admin::auth.users.trash') }}" class="btn btn-xs btn-default {{ route_is('admin::auth.users.trash') ? 'active' : '' }}">
                        <i class="fa fa-fw fa-trash-o"></i> Trashed
                    </a>
                </div>

                @unless($trashed)
                    <div class="btn-group">
                        <button class="btn btn-default btn-xs dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Roles <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right">
                            <li>{{ link_to_route('admin::auth.users.index', 'All') }}</li>
                            @foreach($rolesFilters as $filterLink)
                                <li>{!! $filterLink !!}</li>
                            @endforeach
                        </ul>
                    </div>
                @endunless

                <a href="{{ route('admin::auth.users.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th style="width: 40px;"></th>
                            <th>Username</th>
                            <th>Full name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th class="text-center">Last activity</th>
                            <th class="text-center" style="width: 80px;">Status</th>
                            <th class="text-right" style="width: 160px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($users->count())
                            @foreach($users as $user)
                            <tr>
                                <td class="text-center">
                                    {{ Html::image($user->gravatar, $user->username, ['class' => 'img-circle', 'style' => 'width: 24px;']) }}
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
                                    <small>{{ $user->formatted_last_activity }}</small>
                                </td>
                                <td class="text-center">
                                    @if ($user->isAdmin())
                                        <span class="label label-warning" data-toggle="tooltip" data-original-title="SUPER ADMIN" style="margin-right: 5px;"><i class="fa fa-fw fa-star"></i></span>
                                    @endif

                                    @if ($user->isActive())
                                        <span class="label label-success" data-toggle="tooltip" data-original-title="Enabled">
                                            <i class="fa fa-check"></i>
                                        </span>
                                    @else
                                        <span class="label label-default" data-toggle="tooltip" data-original-title="Disabled">
                                            <i class="fa fa-ban"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @include('auth::admin.users._partials.table-actions')
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
@endsection

@section('modals')
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE MODAL --}}
        <div id="activateUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'PUT', 'id' => 'activateUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="activateUserModalLabel"></h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            {{ Form::button('Cancel', ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                            <button id="activateBtn" type="submit" class="btn btn-sm btn-success" data-loading-text="Loading&hellip;" style="display: none;">
                                <i class="fa fa-fw fa-power-off"></i> Activate
                            </button>
                            <button id="disableBtn" type="submit" class="btn btn-sm btn-inverse" data-loading-text="Loading&hellip;" style="display: none;">
                                <i class="fa fa-fw fa-power-off"></i> Disable
                            </button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>

        {{-- RESTORE MODAL --}}
        @if ($trashed)
            <div id="restoreUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="restoreUserModalLabel">
                <div class="modal-dialog" role="document">
                    {{ Form::open(['method' => 'PUT', 'id' => 'restoreUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
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

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
        <div id="deleteUserModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'DELETE', 'id' => 'deleteUserForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
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
                $activateUserForm  = $('form#activateUserForm'),
                activateUserUrl    = "{{ route('admin::auth.users.activate', [':id']) }}";

            $('a[href="#activateUserModal"]').on('click', function (event) {
                event.preventDefault();
                var enabled      = $(this).data('user-status') === 'enabled',
                    modalMessage = 'Are you sure you want to ' + (enabled ? '<span class="label label-inverse">disable</span>' : '<span class="label label-success">activate</span>') + ' this user : <strong>:username</strong> ?';

                $activateUserForm.attr('action', activateUserUrl.replace(':id', $(this).data('user-id')));
                $activateUserModal.find('.modal-title').text((enabled ? 'Disable' : 'Activate') + ' User');
                $activateUserModal.find('.modal-body p').html(modalMessage.replace(':username', $(this).data('user-name')));
                if (enabled) {
                    $activateUserForm.find('button#activateBtn').hide();
                    $activateUserForm.find('button#disableBtn').show();
                }
                else {
                    $activateUserForm.find('button#activateBtn').show();
                    $activateUserForm.find('button#disableBtn').hide();
                }
                $activateUserModal.modal('show');
            });

            $activateUserModal.on('hidden.bs.modal', function () {
                $activateUserForm.attr('action', activateUserUrl);
                $activateUserModal.find('.modal-title').text('');
                $activateUserModal.find('.modal-body p').html('');

                $activateUserForm.find('button[type="submit"]').hide();
            });

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

        @if ($trashed)
        {{-- RESTORE MODAL --}}
        <script>
            var $restoreUserModal = $('div#restoreUserModal'),
                $restoreUserForm  = $('form#restoreUserForm'),
                restoreUserUrl    = "{{ route('admin::auth.users.restore', [':id']) }}";

            $('a[href="#restoreUserModal"]').on('click', function (event) {
                event.preventDefault();
                var modalMessage = 'Are you sure you want to <span class="label label-primary">restore</span> this user : <strong>:username</strong> ?';

                $restoreUserForm.attr('action', restoreUserUrl.replace(':id', $(this).data('user-id')));
                $restoreUserModal.find('.modal-body p').html(modalMessage.replace(':username', $(this).data('user-name')));

                $restoreUserModal.modal('show');
            });

            $restoreUserModal.on('hidden.bs.modal', function () {
                $restoreUserForm.attr('action', restoreUserUrl);
                $restoreUserModal.find('.modal-body p').html('');
            });

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
                $deleteUserForm  = $('form#deleteUserForm'),
                deleteUserUrl    = "{{ route('admin::auth.users.delete', [':id']) }}";

            $('a[href="#deleteUserModal"]').on('click', function (event) {
                event.preventDefault();
                var modalMessage = 'Are you sure you want to <span class="label label-danger">delete</span> this user : <strong>:username</strong> ?';

                $deleteUserForm.attr('action', deleteUserUrl.replace(':id', $(this).data('user-id')));
                $deleteUserModal.find('.modal-body p').html(modalMessage.replace(':username', $(this).data('user-name')));

                $deleteUserModal.modal('show');
            });

            $deleteUserModal.on('hidden.bs.modal', function () {
                $deleteUserForm.attr('action', deleteUserUrl);
                $deleteUserModal.find('.modal-body p').html('');
            });

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
    @endcan
@endsection