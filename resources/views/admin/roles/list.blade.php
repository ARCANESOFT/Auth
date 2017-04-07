<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $roles */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> {{ trans('auth::roles.titles.roles') }} <small>{{ trans('auth::roles.titles.roles-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-warning">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $roles])

            <div class="box-tools">
                @include('core::admin._includes.actions.icon-links.add', ['url' => route('admin::auth.roles.create')])
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
                                    @include('core::admin._includes.actions.icon-links.show', ['url' => route('admin::auth.roles.show', [$role->hashed_id])])
                                @endcan

                                @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
                                    @include('core::admin._includes.actions.icon-links.edit', $role->isLocked() ? ['disabled' => true] : ['url' => route('admin::auth.roles.edit', [$role->hashed_id])])
                                    @includeWhen($role->isActive(), 'core::admin._includes.actions.icon-links.disable', $role->isLocked() ? ['disabled' => true] : ['url' => '#activateRoleModal', 'attributes' => ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name, 'data-role-status' => 'enabled']])
                                    @includeWhen( ! $role->isActive(), 'core::admin._includes.actions.icon-links.enable', $role->isLocked() ? ['disabled' => true] : ['url' => '#activateRoleModal', 'attributes' => ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name, 'data-role-status' => 'disabled']])
                                @endcan

                                @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
                                    @include('core::admin._includes.actions.icon-links.delete', $role->isLocked() ? ['disabled' => true] : ['url' => '#deleteRoleModal', 'attributes' => ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name]])
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
                            {{ Form::button(ucfirst(trans('core::actions.cancel')), ['class' => 'btn btn-sm btn-default pull-left', 'data-dismiss' => 'modal']) }}
                            <button type="submit" class="btn btn-sm btn-inverse" data-loading-text="{{ trans('core::generals.loading') }}">
                                <i class="fa fa-fw fa-power-off"></i> {{ ucfirst(trans('core::actions.disable')) }}
                            </button>
                            <button type="submit" class="btn btn-sm btn-success" data-loading-text="{{ trans('core::generals.loading') }}">
                                <i class="fa fa-fw fa-power-off"></i> {{ ucfirst(trans('core::actions.enable')) }}
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
                            <h4 class="modal-title" id="deleteRoleModalLabel">{{ trans('auth::roles.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
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
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
        {{-- ACTIVATE SCRIPT --}}
        <script>
            var $activateRoleModal = $('div#activateRoleModal'),
                $activateRoleForm  = $('form#activateRoleForm'),
                activateRoleUrl    = "{{ route('admin::auth.roles.activate', [':id']) }}";

            $('a[href="#activateRoleModal"]').on('click', function (event) {
                event.preventDefault();

                var that           = $(this),
                    enabled        = that.data('role-status') === 'enabled',
                    enableTitle    = '{{ trans('auth::roles.modals.enable.title') }}',
                    disableTitle   = '{{ trans('auth::roles.modals.disable.title') }}',
                    enableMessage  = '{!! trans('auth::roles.modals.enable.message') !!}',
                    disableMessage = '{!! trans('auth::roles.modals.disable.message') !!}';

                $activateRoleForm.attr('action', activateRoleUrl.replace(':id', that.data('role-id')));
                $activateRoleModal.find('.modal-title').text((enabled ? disableTitle : enableTitle));
                $activateRoleModal.find('.modal-body p').html(
                    (enabled ? disableMessage : enableMessage).replace(':name', that.data('role-name'))
                );

                if (enabled) {
                    $activateRoleForm.find('button[type="submit"].btn-success').hide();
                    $activateRoleForm.find('button[type="submit"].btn-inverse').show();
                }
                else {
                    $activateRoleForm.find('button[type="submit"].btn-success').show();
                    $activateRoleForm.find('button[type="submit"].btn-inverse').hide();
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

                axios.put($activateRoleForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $activateRoleModal.modal('hide');
                             location.reload();
                         }
                         else {
                             alert('ERROR ! Check the console !');
                             console.error(response.data.message);
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
                var that         = $(this),
                    modalMessage = '{!! trans('auth::roles.modals.delete.message') !!}';


                $deleteRoleForm.attr('action', deleteRoleUrl.replace(':id', that.data('role-id')));
                $deleteRoleModal.find('.modal-body p').html(modalMessage.replace(':name', that.data('role-name')));

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

                axios.delete($deleteRoleForm.attr('action'))
                     .then(function (response) {
                         if (response.data.status === 'success') {
                             $deleteRoleModal.modal('hide');
                             location.reload();
                         }
                         else {
                             alert('ERROR ! Check the console !');
                             console.error(response.data.message);
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
        </script>
    @endcan
@endsection
