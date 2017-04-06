<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $roles */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> {{ trans('auth::roles.titles.roles') }} <small>{{ trans('auth::roles.titles.roles-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-warning">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $roles])

            <div class="box-tools">
                @include('core::admin._includes.actions.add-icon-link', ['url' => route('admin::auth.roles.create')])
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>{{ trans('auth::roles.attributes.name') }}</th>
                            <th>{{ trans('auth::roles.attributes.slug') }}</th>
                            <th>{{ trans('auth::roles.attributes.description') }}</th>
                            <th class="text-center">{{ trans('auth::users.titles.users') }}</th>
                            <th class="text-center">{{ trans('auth::permissions.titles.permissions') }}</th>
                            <th class="text-center" style="width: 60px;">{{ trans('core::generals.actions') }}</th>
                            <th class="text-center" style="width: 60px;">{{ trans('auth::roles.attributes.locked') }}</th>
                            <th class="text-right" style="width: 135px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                        <?php /** @var  \Arcanesoft\Auth\Models\Role  $role */ ?>
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <span class="label label-primary">{{ $role->slug }}</span>
                            </td>
                            <td>{{ $role->description }}</td>
                            <td class="text-center">
                                @include('core::admin._includes.labels.count-info', ['count' => $role->users->count()])
                            </td>
                            <td class="text-center">
                                @include('core::admin._includes.labels.count-info', ['count' => $role->permissions->count()])
                            </td>
                            <td class="text-center">
                                @include('core::admin._includes.labels.active-icon', ['active' => $role->isActive()])
                            </td>
                            <td class="text-center">
                                @include('core::admin._includes.labels.locked-icon', ['locked' => $role->isLocked()])
                            </td>
                            <td class="text-right">
                                @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_SHOW)
                                    @include('core::admin._includes.actions.show-icon-link', ['url' => route('admin::auth.roles.show', [$role->hashed_id])])
                                @endcan

                                @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
                                    @include('core::admin._includes.actions.edit-icon-link', $role->isLocked() ? ['disabled' => true] : ['url' => route('admin::auth.roles.edit', [$role->hashed_id])])

                                    @if ($role->isActive())
                                        @include('core::admin._includes.actions.disable-icon-link', $role->isLocked() ? ['disabled' => true] : ['url' => '#activateRoleModal', 'attributes' => ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name, 'data-role-status' => 'enabled']])
                                    @else
                                        @include('core::admin._includes.actions.enable-icon-link', $role->isLocked() ? ['disabled' => true] : ['url' => '#activateRoleModal', 'attributes' => ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name, 'data-role-status' => 'disabled']])
                                    @endif
                                @endcan

                                @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
                                    @include('core::admin._includes.actions.delete-icon-link', $role->isLocked() ? ['disabled' => true] : ['url' => '#deleteRoleModal', 'attributes' => ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name]])
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if ($roles->hasPages())
            <div class="box-footer clearfix">{!! $roles->render() !!}</div>
        @endif
    </div>
@endsection

@section('modals')
    {{-- ACTIVATE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
        <div id="activateRoleModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="activateRoleModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'PUT', 'id' => 'activateRoleForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title" id="activateRoleModalLabel"></h4>
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
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
        <div id="deleteRoleModal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="deleteRoleModalLabel">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'DELETE', 'id' => 'deleteRoleForm', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
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
        {{-- ACTIVATE SCRIPT --}}
        <script>
            var $activateRoleModal = $('div#activateRoleModal'),
                $activateRoleForm  = $('form#activateRoleForm'),
                activateRoleUrl   = "{{ route('admin::auth.roles.activate', [':id']) }}";

            $('a[href="#activateRoleModal"]').on('click', function (event) {
                event.preventDefault();
                var enabled      = $(this).data('role-status') === 'enabled',
                    modalMessage = 'Are you sure you want to ' + (enabled ? '<span class="label label-inverse">disable</span>' : '<span class="label label-success">activate</span>') + ' this role : <strong>:name</strong> ?';

                $activateRoleForm.attr('action', activateRoleUrl.replace(':id', $(this).data('role-id')));
                $activateRoleModal.find('.modal-title').text((enabled ? 'Disable' : 'Activate') + ' Role');
                $activateRoleModal.find('.modal-body p').html(modalMessage.replace(':name', $(this).data('role-name')));
                if (enabled) {
                    $activateRoleForm.find('button#activateBtn').hide();
                    $activateRoleForm.find('button#disableBtn').show();
                }
                else {
                    $activateRoleForm.find('button#activateBtn').show();
                    $activateRoleForm.find('button#disableBtn').hide();
                }
                $activateRoleModal.modal('show');
            });

            $activateRoleModal.on('hidden.bs.modal', function () {
                $activateRoleForm.attr('action', activateRoleUrl);
                $activateRoleModal.find('.modal-title').text('');
                $(this).find('.modal-body p').html('');

                $activateRoleForm.find('button[type="submit"]').hide();
            });

            $activateRoleForm.submit(function (event) {
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
        </script>
    @endcan

    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
        {{-- DELETE SCRIPT --}}
        <script>
            var $deleteRoleModal = $('div#deleteRoleModal'),
                $deleteRoleForm  = $('form#deleteRoleForm'),
                deleteRoleUrl   = "{{ route('admin::auth.roles.delete', [':id']) }}";

            $('a[href="#deleteRoleModal"]').on('click', function (event) {
                event.preventDefault();
                var modalMessage = 'Are you sure you want to <span class="label label-danger">delete</span> this role : <strong>:role</strong> ?';

                $deleteRoleForm.attr('action', deleteRoleUrl.replace(':id', $(this).data('role-id')));
                $deleteRoleModal.find('.modal-body p').html(modalMessage.replace(':role', $(this).data('role-name')));

                $deleteRoleModal.modal('show');
            });

            $deleteRoleModal.on('hidden.bs.modal', function () {
                $deleteRoleForm.attr('action', deleteRoleUrl);
                $(this).find('.modal-body p').html('');
            });

            $deleteRoleForm.submit(function (event) {
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
