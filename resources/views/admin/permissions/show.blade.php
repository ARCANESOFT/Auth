<?php /** @var  \Arcanesoft\Auth\Models\Permission  $permission */ ?>
@section('header')
    <h1><i class="fa fa-fw fa-check-circle"></i> {{ trans('auth::permissions.titles.permissions') }} <small>{{ trans('auth::permissions.titles.permission-details') }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-5">
            {{-- PERMISSION --}}
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('auth::permissions.titles.permission-details') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <tbody>
                                <tr>
                                    <th>{{ trans('auth::permissions.attributes.name') }} :</th>
                                    <td>{{ $permission->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::permissions.attributes.slug') }} :</th>
                                    <td><span class="label label-success">{{ $permission->slug }}</span></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::permissions.attributes.description') }} :</th>
                                    <td>{{ $permission->description }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('auth::roles.titles.roles') }} :</th>
                                    <td>{{ label_count($permission->roles->count()) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.created_at') }} :</th>
                                    <td><small>{{ $permission->created_at }}</small></td>
                                </tr>
                                <tr>
                                    <th>{{ trans('core::generals.updated_at') }} :</th>
                                    <td><small>{{ $permission->updated_at }}</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- PERMISSION GROUP --}}
            @include('auth::admin.permissions._includes.permission-group')
        </div>

        <div class="col-md-7">
            {{-- ROLES --}}
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('auth::roles.titles.roles') }}</h3>
                </div>
                <div class="box-body no-padding">
                    <div class="table-responsive">
                        <table class="table table-condensed no-margin">
                            <thead>
                                <tr>
                                    <th>{{ trans('auth::roles.attributes.name') }}</th>
                                    <th>{{ trans('auth::roles.attributes.description') }}</th>
                                    <th class="text-center">{{ trans('auth::users.titles.users') }}</th>
                                    <th class="text-center" style="width: 60px;">{{ trans('core::generals.status') }}</th>
                                    <th class="text-right" style="width: 75px;">{{ trans('core::generals.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($permission->roles as $role)
                                    <?php /** @var  \Arcanesoft\Auth\Models\Role  $role */ ?>
                                    <tr>
                                        <td>
                                            <span class="label label-primary">{{ $role->name }}</span>
                                        </td>
                                        <td>{{ $role->description }}</td>
                                        <td class="text-center">
                                            {{ label_count($role->users->count()) }}
                                        </td>
                                        <td class="text-center">
                                            {{ label_active_icon($role->isActive()) }}
                                        </td>
                                        <td class="text-right">
                                            @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_SHOW)
                                                {{ ui_link_icon('show', route('admin::auth.roles.show', [$role->hashed_id])) }}
                                            @endcan

                                            @can(Arcanesoft\Auth\Policies\PermissionsPolicy::PERMISSION_UPDATE)
                                                {{ ui_link_icon('detach', '#detach-role-modal', ['data-role-id' => $role->hashed_id, 'data-role-name' => $role->name], $role->isLocked()) }}
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <span class="label label-default">{{ trans('auth::roles.list-empty') }}</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modals')
    @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_UPDATE)
        {{-- DETACH MODAL --}}
        <div id="detach-role-modal" class="modal fade" data-backdrop="false" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                {{ Form::open(['method' => 'DELETE', 'id' => 'detach-role-form', 'class' => 'form form-loading', 'autocomplete' => 'off']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <h4 class="modal-title">{{ trans('auth::permissions.modals.detach.title') }}</h4>
                        </div>
                        <div class="modal-body">
                            <p></p>
                        </div>
                        <div class="modal-footer">
                            {{ ui_button('cancel')->appendClass('pull-left')->setAttribute('data-dismiss', 'modal') }}
                            {{ ui_button('detach', 'submit')->withLoadingText() }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    @endcan
@endsection

@section('scripts')
    {{-- DETACH ROLE MODAL --}}
    @can(Arcanesoft\Auth\Policies\PermissionsPolicy::PERMISSION_UPDATE)
        <script>
            $(function () {
                var $detachRoleModal = $('div#detach-role-modal'),
                    $detachRoleForm  = $('form#detach-role-form'),
                    detachRoleUrl    = "{{ route('admin::auth.permissions.roles.detach', [$permission->hashed_id, ':id']) }}";

                $('a[href="#detach-role-modal"]').on('click', function (e) {
                    e.preventDefault();

                    var that         = $(this),
                        modalMessage = '{!! trans('auth::permissions.modals.detach.message') !!}';

                    $detachRoleForm.attr('action', detachRoleUrl.replace(':id', that.data('role-id')));
                    $detachRoleModal.find('.modal-body p').html(modalMessage.replace(':name', that.data('role-name')));

                    $detachRoleModal.modal('show');
                });

                $detachRoleModal.on('hidden.bs.modal', function () {
                    $detachRoleForm.attr('action', detachRoleUrl);
                    $detachRoleModal.find('.modal-body p').html('');
                });

                $detachRoleForm.on('submit', function (e) {
                    e.preventDefault();

                    var submitBtn = $detachRoleForm.find('button[type="submit"]');
                        submitBtn.button('loading');

                    axios.delete($detachRoleForm.attr('action'))
                         .then(function (response) {
                             if (response.data.status === 'success') {
                                 $detachRoleModal.modal('hide');
                                 location.reload();
                             }
                             else {
                                 alert('ERROR ! Check the console !');
                                 console.error(response.data.message);
                                 submitBtn.button('reset');
                             }
                         })
                         .catch(function (error) {
                             alert('AJAX ERROR ! Check the console !');
                             console.log(error);
                             submitBtn.button('reset');
                         });

                    return false;
                });
            });
        </script>
    @endcan
@endsection
