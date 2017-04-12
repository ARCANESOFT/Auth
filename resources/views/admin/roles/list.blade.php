<?php /** @var  \Illuminate\Pagination\LengthAwarePaginator  $roles */ ?>

@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> {{ trans('auth::roles.titles.roles') }} <small>{{ trans('auth::roles.titles.roles-list') }}</small></h1>
@endsection

@section('content')
    <div class="box box-warning">
        <div class="box-header with-border">
            @include('core::admin._includes.pagination.labels', ['paginator' => $roles])

            <div class="box-tools">
                {{ ui_link_icon('add', route('admin::auth.roles.create')) }}
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
                            <th class="text-center" style="width: 60px;">{{ trans('core::generals.status') }}</th>
                            <th class="text-center" style="width: 60px;">{{ trans('auth::roles.attributes.locked') }}</th>
                            <th class="text-right" style="width: 135px;">{{ trans('core::generals.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <?php /** @var  \Arcanesoft\Auth\Models\Role  $role */ ?>
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <span class="label label-primary">{{ $role->slug }}</span>
                                </td>
                                <td>{{ $role->description }}</td>
                                <td class="text-center">
                                    {{ label_count($role->users->count()) }}
                                </td>
                                <td class="text-center">
                                    {{ label_count($role->permissions->count()) }}
                                </td>
                                <td class="text-center">
                                    {{ label_active_icon($role->isActive()) }}
                                </td>
                                <td class="text-center">
                                    {{ label_locked_icon($role->isLocked()) }}
                                </td>
                                <td class="text-right">
                                    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_SHOW)
                                        {{ ui_link_icon('show', route('admin::auth.roles.show', [$role->hashed_id])) }}
                                    @endcan

                                    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
                                        {{ ui_link_icon('edit', route('admin::auth.roles.edit', [$role->hashed_id]), [], $role->isLocked()) }}
                                        {{ ui_link_icon($role->isActive() ? 'disable' : 'enable', '#activate-role-modal', ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name, 'data-current-status' => 'enabled'], $role->isLocked()) }}
                                    @endcan

                                    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
                                        {{ ui_link_icon('delete', '#delete-role-modal', ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name], $role->isLocked()) }}
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">
                                    <span class="label label-default">{{ trans('auth::roles.list-empty') }}</span>
                                </td>
                            </tr>
                        @endforelse
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
        <div id="activate-role-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'PUT', 'id' => 'activate-role-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title"></h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('disable', 'submit')->withLoadingText() }}
                            {{ ui_button('enable', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
        <div id="delete-role-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'DELETE', 'id' => 'delete-role-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('auth::roles.modals.delete.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('delete', 'submit')->withLoadingText() }}
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
            $(function () {
                var $activateRoleModal = $('div#activate-role-modal'),
                    $activateRoleForm  = $('form#activate-role-form'),
                    activateRoleUrl    = "{{ route('admin::auth.roles.activate', [':id']) }}";

                $('a[href="#activate-role-modal"]').on('click', function (e) {
                    e.preventDefault();

                    var that           = $(this),
                        enabled        = that.data('current-status') === 'enabled',
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
                    $activateRoleModal.find('.modal-body p').html('');

                    $activateRoleForm.find('button[type="submit"]').hide();
                });

                $activateRoleForm.submit(function (e) {
                    e.preventDefault();

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
            });
        </script>
    @endcan

    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_DELETE)
        {{-- DELETE SCRIPT --}}
        <script>
            $(function () {
                var $deleteRoleModal = $('div#delete-role-modal'),
                    $deleteRoleForm  = $('form#delete-role-form'),
                    deleteRoleUrl   = "{{ route('admin::auth.roles.delete', [':id']) }}";

                $('a[href="#delete-role-modal"]').on('click', function (e) {
                    e.preventDefault();
                    var that         = $(this),
                        modalMessage = '{!! trans('auth::roles.modals.delete.message') !!}';

                    $deleteRoleForm.attr('action', deleteRoleUrl.replace(':id', that.data('role-id')));
                    $deleteRoleModal.find('.modal-body p').html(modalMessage.replace(':name', that.data('role-name')));

                    $deleteRoleModal.modal('show');
                });

                $deleteRoleModal.on('hidden.bs.modal', function () {
                    $deleteRoleForm.attr('action', deleteRoleUrl);
                    $deleteRoleModal.find('.modal-body p').html('');
                });

                $deleteRoleForm.on('submit', function (e) {
                    e.preventDefault();

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
            });
        </script>
    @endcan
@endsection
