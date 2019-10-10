@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fas fa-fw fa-shield-alt"></i> @lang("Permission's details")
@endsection

<?php
/** @var  Arcanesoft\Auth\Models\Permission  $permission */
?>

@section('content')
    <div class="row">
        <div class="col-md-5 col-lg-4">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header p-2">@lang('Permission')</div>
                <table class="table table-borderless table-md mb-0">
                    <tbody>
                        <tr>
                            <th class="text-muted">@lang('Group') :</th>
                            <td class="text-right">{{ $permission->group->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Category') :</th>
                            <td class="text-right">{{ $permission->category }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Name') :</th>
                            <td class="text-right">{{ $permission->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Description') :</th>
                            <td class="text-right"><small>{{ $permission->description }}</small></td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Roles') :</th>
                            <td class="text-right">
                                {{ arcanesoft\ui\count_pill($roles->count()) }}
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Created at') :</th>
                            <td class="text-right"><small class="text-muted">{{ $permission->created_at }}</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @can(Arcanesoft\Foundation\Policies\System\AbilitiesPolicy::ability('show'))
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header p-2">@lang('Gate')</div>
                <table class="table table-borderless table-md mb-0">
                    <tbody>
                        <tr>
                            <th class="text-muted">@lang('Ability') :</th>
                            <td class="text-right">
                                <div class="badge badge-outline-dark">{{ $permission->ability }}</div>
                            </td>
                        </tr>
                        <tr>
                            <th class="text-muted">@lang('Registered') :</th>
                            <td class="text-right">
                                @if ($permission->isAbilityRegistered())
                                    <span class="badge badge-outline-success" data-toggle="tooltip" data-original-title="@lang('Yes')">
                                        <i class="fas fa-fw fa-check"></i>
                                    </span>
                                @else
                                    <span class="badge badge-outline-secondary" data-toggle="tooltip" data-original-title="@lang('No')">
                                        <i class="fas fa-fw fa-ban"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="card-footer text-right px-2">
                    {{ arcanesoft\ui\action_link('show', route('admin::foundation.system.abilities.show', $permission->ability))->size('sm') }}
                </div>
            </div>
            @endcan
        </div>
        <div class="col-md-7 col-lg-8">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header p-2">@lang('Roles')</div>
                <table class="table table-borderless table-md mb-0">
                    <thead>
                        <th>@lang('Name')</th>
                        <th>@lang('Description')</th>
                        <th class="text-center">@lang('Users')</th>
                        <th class="text-center">@lang('Locked')</th>
                        <th class="text-center">@lang('Status')</th>
                        <th class="text-right">@lang('Actions')</th>
                    </thead>
                    <tbody>
                        @forelse($roles as $role)
                            <?php /** @var  \Arcanesoft\Auth\Models\Role  $role */ ?>
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td class="text-center">{{ arcanesoft\ui\count_pill($role->users->count()) }}</td>
                                <td class="text-center">
                                    @if($role->isLocked())
                                        <span class="status status-danger" data-toggle="tooltip" data-placement="top" title="@lang('Locked')"></span>
                                    @else
                                        <span class="status status-secondary" data-toggle="tooltip" data-placement="top" title="@lang('Unlocked')"></span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($role->isActive())
                                        <span class="status status-success status-animated" data-toggle="tooltip" data-placement="top" title="@lang('Activated')"></span>
                                    @else
                                        <span class="status status-secondary" data-toggle="tooltip" data-placement="top" title="@lang('Deactivated')"></span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('show'), [$role])
                                        {{ arcanesoft\ui\action_link_icon('show', route('admin::auth.roles.show', [$role]))->size('sm') }}
                                    @endcan

                                    @unless($role->isLocked())
                                        @can(Arcanesoft\Auth\Policies\PermissionsPolicy::ability('roles.detach'), $permission)
                                            <button class="btn btn-sm btn-danger"
                                                    data-toggle="tooltip" data-placement="top" title="@lang('Detach')"
                                                    onclick="window.Foundation.$emit('auth::permissions.detach-role', {{ json_encode(['id' => $role->getRouteKey(), 'name' => $role->name]) }})">
                                                <i class="fas fa-fw fa-unlink"></i>
                                            </button>
                                        @endcan
                                    @endunless
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">@lang('The list is empty!')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    {{-- DETACH ROLE MODAL --}}
    @can(Arcanesoft\Auth\Policies\PermissionsPolicy::ability('roles.detach'), $permission)
        <div class="modal modal-danger fade" id="detach-role-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.permissions.roles.detach', $permission, ':id'], 'method' => 'DELETE', 'id' => 'detach-role-form']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelTitleId">@lang('Detach Role')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer justify-content-between">
                        {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-fw fa-unlink"></i> @lang('Detach')
                        </button>
                    </div>
                </div>
                {{ form()->close() }}
            </div>
        </div>
    @endcan
@endpush

@push('scripts')
    {{-- DETACH ROLE SCRIPT --}}
    @can(Arcanesoft\Auth\Policies\PermissionsPolicy::ability('roles.detach'), $permission)
    <script>
        window.ready(() => {
            let $detachRoleModal = $('div#detach-role-modal'),
                $detachRoleForm  = $('form#detach-role-form'),
                detachRoleAction = $detachRoleForm.attr('action');

            window.Foundation.$on('auth::permissions.detach-role', ({id, name}) => {
                $detachRoleForm.attr('action', detachRoleAction.replace(':id', id));

                $detachRoleModal.find('.modal-body').html("@lang('Are you sure you want to detach role: :name ?')".replace(':name', name));

                $detachRoleModal.modal('show');
            });

            $detachRoleForm.on('submit', (event) => {
                event.preventDefault();

                let submitBtn = window.Foundation.ui.loadingButton(
                    $detachRoleForm[0].querySelector('button[type="submit"]:not([style*="display: none"])')
                );
                submitBtn.loading();

                window.request().delete($detachRoleForm.attr('action'))
                    .then((response) => {
                        if (response.data.code === 'success') {
                            $detachRoleModal.modal('hide');
                            location.reload();
                        }
                        else {
                            alert('ERROR ! Check the console !');
                            submitBtn.reset();
                        }
                    })
                    .catch((error) => {
                        alert('AJAX ERROR ! Check the console !');
                        submitBtn.reset();
                    });

                return false;
            });

            $detachRoleModal.on('hidden.bs.modal', () => {
                $detachRoleForm.attr('action', detachRoleAction);
            });
        });
    </script>
    @endcan
@endpush