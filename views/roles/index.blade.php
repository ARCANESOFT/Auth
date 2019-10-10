@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-user-tag"></i> @lang('Roles')
@endsection

@push('content-nav')
    <div class="mb-3 text-right">
        <a href="{{ route('admin::auth.roles.metrics') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.roles.metrics']) }}">@lang('Metrics')</a>
        <a href="{{ route('admin::auth.roles.index') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.roles.index']) }}">@lang('Roles')</a>
        {{ arcanesoft\ui\action_link('add', route('admin::auth.roles.create'))->size('sm') }}
    </div>
@endpush

@section('content')
    <div class="card card-borderless shadow-sm mb-3">
        <div class="table-responsive">
            <table id="roles-table" class="table table-md table-hover mb-0">
                <thead>
                    <tr>
                        <th>@lang('Name')</th>
                        <th>@lang('Description')</th>
                        <th class="text-center">@lang('Users')</th>
                        <th class="text-center">@lang('Locked')</th>
                        <th class="text-center">@lang('Status')</th>
                        <th class="text-right">@lang('Actions')</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push('modals')
    {{-- ACIVATE MODAL --}}
    @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('activate'))
        <div class="modal modal-danger fade" id="activate-role-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="activateRoleTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.roles.activate', ':id'], 'method' => 'PUT', 'id' => 'activate-role-form']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="activateRoleTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer justify-content-between">
                        {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                        {{ arcanesoft\ui\action_button('activate')->id('activateRoleBtn')->submit() }}
                        {{ arcanesoft\ui\action_button('deactivate')->id('deactivateRoleBtn')->submit() }}
                    </div>
                </div>
                {{ form()->close() }}
            </div>
        </div>
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('delete'))
        <div class="modal modal-danger fade" id="delete-role-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.roles.delete', ':id'], 'method' => 'DELETE', 'id' => 'delete-role-form']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modelTitleId">@lang('Delete Role')</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @lang('Are you sure you want to delete this role ?')
                    </div>
                    <div class="modal-footer justify-content-between">
                        {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                        {{ arcanesoft\ui\action_button('delete')->submit() }}
                    </div>
                </div>
                {{ form()->close() }}
            </div>
        </div>
    @endcan
@endpush

@push('scripts')
    <script>
        window.ready(() => {
            {{-- DATATABLE --}}
            window.plugins.datatable('table#roles-table', {
                ajax: "{{ route('admin::auth.roles.datatables.index') }}",
                serverSide: true,
                processing: true,
                columns: [
                    { data: 'name' },
                    { data: 'description' },
                    { data: 'users_count', searchable: false, class: 'text-center'},
                    { data: 'locked', orderable: false, searchable: false, class: 'text-center' },
                    { data: 'status', orderable: false, searchable: false, class: 'text-center' },
                    { data: 'actions', orderable: false, searchable: false, class: 'text-right' }
                ],
            })

            {{-- ACTIVATE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('activate'))
                let $activateRoleModal = $('div#activate-role-modal'),
                    $activateRoleForm  = $('form#activate-role-form'),
                    activateRoleAction = $activateRoleForm.attr('action');

                window.Foundation.$on('auth::roles.activate', ({id, status}) => {
                    $activateRoleForm.attr('action', activateRoleAction.replace(':id', id));

                    if (status === 'deactivated') {
                        $activateRoleModal.find('.modal-title').html("@lang('Activate Role')");
                        $activateRoleModal.find('.modal-body').html("@lang('Are you sure you want to activate role ?')");
                        $activateRoleModal.find('#activateRoleBtn').show();
                        $activateRoleModal.find('#deactivateRoleBtn').hide();
                    }
                    else if (status === 'activated') {
                        $activateRoleModal.find('.modal-title').html("@lang('Deactivate Role')");
                        $activateRoleModal.find('.modal-body').html("@lang('Are you sure you want to deactivate role ?')");
                        $activateRoleModal.find('#activateRoleBtn').hide();
                        $activateRoleModal.find('#deactivateRoleBtn').show();
                    }

                    $activateRoleModal.modal('show');
                });

                $activateRoleForm.on('submit', (event) => {
                    event.preventDefault();

                    let submitBtn = window.Foundation.ui.loadingButton(
                        $activateRoleForm[0].querySelector('button[type="submit"]:not([style*="display: none"])')
                    );
                    submitBtn.loading();

                    window.request().put($activateRoleForm.attr('action'))
                        .then((response) => {
                            if (response.data.code === 'success') {
                                $activateRoleModal.modal('hide');
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

                $activateRoleModal.on('hidden.bs.modal', () => {
                    $activateRoleForm.attr('action', activateRoleAction);
                });
            @endcan

            {{-- DELETE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\RolesPolicy::ability('delete'))
                let $deleteRoleModal = $('div#delete-role-modal'),
                    $deleteRoleForm  = $('form#delete-role-form'),
                    deleteRoleAction = $deleteRoleForm.attr('action');

                window.Foundation.$on('auth::roles.delete', ({id}) => {
                    $deleteRoleForm.attr('action', deleteRoleAction.replace(':id', id));
                    $deleteRoleModal.modal('show');
                })

                $deleteRoleForm.on('submit', (event) => {
                    event.preventDefault();

                    let submitBtn = window.Foundation.ui.loadingButton(
                        $deleteRoleForm[0].querySelector('button[type="submit"]')
                    );
                    submitBtn.loading();

                    window.request().delete($deleteRoleForm.attr('action'))
                        .then((response) => {
                            if (response.data.code === 'success') {
                                $deleteRoleModal.modal('hide');
                                location.reload();
                            }
                            else {
                                alert('ERROR ! Check the console !');
                                submitBtn.button('reset');
                            }
                        })
                        .catch((error) => {
                            alert('AJAX ERROR ! Check the console !');
                            console.log(error);
                            submitBtn.button('reset');
                        });

                    return false;
                });

                $deleteRoleModal.on('hidden.bs.modal', () => {
                    $deleteRoleForm.attr('action', deleteRoleAction);
                });
            @endcan
        });
    </script>
@endpush
