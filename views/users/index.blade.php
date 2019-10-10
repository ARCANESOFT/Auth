@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-users"></i> @lang('Users')
@endsection

@push('content-nav')
    <div class="mb-3 text-right">
        <a href="{{ route('admin::auth.users.metrics') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.users.metrics']) }}">@lang('Metrics')</a>

        <div class="btn-group ml-auto mr-1" role="group" aria-label="Basic example">
            <a href="{{ route('admin::auth.users.index') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.users.index']) }}">@lang('All')</a>
            <a href="{{ route('admin::auth.users.trash') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.users.trash']) }}">@lang('Trash')</a>
        </div>
        {{ arcanesoft\ui\action_link('add', route('admin::auth.users.create'))->size('sm') }}
    </div>
@endpush

@section('content')
    <div class="card card-borderless shadow-sm">
        <div class="table-responsive">
            <table id="users-table" class="table table-hover table-md mb-0">
                <thead>
                    <tr>
                        <th></th>
                        <th>@lang('First Name')</th>
                        <th>@lang('Last Name')</th>
                        <th>@lang('Email')</th>
                        <th class="text-center">@lang('Created at')</th>
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
    <div class="modal modal-danger fade" id="activate-user-modal" data-backdrop="static"
         tabindex="-1" role="dialog" aria-labelledby="activateUserTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            {{ form()->open(['route' => ['admin::auth.users.activate', ':id'], 'method' => 'PUT', 'id' => 'activate-user-form']) }}
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="activateUserTitle"></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div id="activateUserMessage" class="modal-body">
                    </div>
                    <div class="modal-footer justify-content-between">
                        {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                        {{ arcanesoft\ui\action_button('activate')->id('activateUserBtn')->submit() }}
                        {{ arcanesoft\ui\action_button('deactivate')->id('deactivateUserBtn')->submit() }}
                    </div>
                </div>
            {{ form()->close() }}
        </div>
    </div>

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('delete'))
        <div class="modal modal-danger fade" id="delete-user-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.users.delete', ':id'], 'method' => 'DELETE', 'id' => 'delete-user-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelTitleId">@lang('Delete User')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @lang('Are you sure you want to delete this user ?')
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

    {{-- RESTORE MODAL --}}
    @if ($trash)
    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('restore'))
        <div class="modal modal-danger fade" id="restore-user-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.users.restore', ':id'], 'method' => 'PUT', 'id' => 'restore-user-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modelTitleId">@lang('Restore User')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @lang('Are you sure you want to restore this user ?')
                        </div>
                        <div class="modal-footer justify-content-between">
                            {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                            {{ arcanesoft\ui\action_button('restore')->submit() }}
                        </div>
                    </div>
                {{ form()->close() }}
            </div>
        </div>
    @endcan
    @endcan
@endpush

@push('scripts')
    <script>
        window.ready(() => {
            window.plugins.datatable('table#users-table', {
                ajax: "{{ route($trash ? 'admin::auth.users.datatables.trash' : 'admin::auth.users.datatables.index') }}",
                serverSide: true,
                processing: true,
                order: [[1, 'asc']],
                columns: [
                    { data: 'avatar', orderable: false, searchable: false },
                    { data: 'first_name' },
                    { data: 'last_name' },
                    { data: 'email' },
                    { data: 'created_at', class: 'text-center'},
                    { data: 'status', class: 'text-center', orderable: false, searchable: false },
                    { data: 'actions', class: 'text-right', orderable: false, searchable: false }
                ],
            });

            {{-- ACTIVATE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('activate'))
            let $activateUserModal = $('div#activate-user-modal'),
                $activateUserForm  = $('form#activate-user-form'),
                activateUserAction = $activateUserForm.attr('action');

            window.Foundation.$on('auth::users.activate', ({id, status}) => {
                $activateUserForm.attr('action', activateUserAction.replace(':id', id));

                if (status === 'activated') {
                    $activateUserModal.find('#activateUserTitle').html("{{ __('Deactivate User') }}");
                    $activateUserModal.find('#activateUserMessage').html("{{ __('Are you sure you want to deactivate this user ?') }}");
                    $activateUserModal.find('#activateUserBtn').hide();
                    $activateUserModal.find('#deactivateUserBtn').show();
                }
                else {
                    $activateUserModal.find('#activateUserTitle').html("{{ __('Activate User') }}");
                    $activateUserModal.find('#activateUserMessage').html("{{ __('Are you sure you want to activate this user ?') }}");
                    $activateUserModal.find('#activateUserBtn').show();
                    $activateUserModal.find('#deactivateUserBtn').hide();
                }

                $activateUserModal.modal('show');
            });

            $activateUserForm.on('submit', (event) => {
                event.preventDefault();

                let submitBtn = window.Foundation.ui.loadingButton(
                    $activateUserForm[0].querySelector('button[type="submit"]:not([style*="display: none"])')
                );
                submitBtn.loading();

                window.request().put($activateUserForm.attr('action'))
                      .then((response) => {
                          if (response.data.code === 'success') {
                              $activateUserModal.modal('hide');
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

            $activateUserModal.on('hidden.bs.modal', () => {
                $activateUserForm.attr('action', activateUserAction);
            });
            @endcan

            {{-- DELETE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('delete'))
            let $deleteUserModal = $('div#delete-user-modal'),
                $deleteUserForm  = $('form#delete-user-form'),
                deleteUserAction = $deleteUserForm.attr('action');

            window.Foundation.$on('auth::users.delete', ({id}) => {
                $deleteUserForm.attr('action', deleteUserAction.replace(':id', id));
                $deleteUserModal.modal('show');
            })

            $deleteUserForm.on('submit', (event) => {
                event.preventDefault();

                let submitBtn = window.Foundation.ui.loadingButton(
                    $deleteUserForm[0].querySelector('button[type="submit"]')
                );
                submitBtn.loading();

                window.request().delete($deleteUserForm.attr('action'))
                    .then((response) => {
                        if (response.data.code === 'success') {
                            $deleteUserModal.modal('hide');
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

            $deleteUserModal.on('hidden.bs.modal', () => {
                $deleteUserForm.attr('action', deleteUserAction);
            });
            @endcan

            {{-- RESTORE SCRIPT --}}
            @if ($trash)
            @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('restore'))
                let $restoreUserModal = $('div#restore-user-modal'),
                    $restoreUserForm  = $('form#restore-user-form'),
                    restoreUserAction = $restoreUserForm.attr('action');

                window.Foundation.$on('auth::users.restore', ({id}) => {
                    $restoreUserForm.attr('action', restoreUserAction.replace(':id', id));
                    $restoreUserModal.modal('show');
                });

                $restoreUserForm.on('submit', (event) => {
                    event.preventDefault();

                    let submitBtn = window.Foundation.ui.loadingButton(
                        $restoreUserForm[0].querySelector('button[type="submit"]')
                    );
                    submitBtn.loading();

                    window.request().put($restoreUserForm.attr('action'))
                        .then((response) => {
                            if (response.data.code === 'success') {
                                $restoreUserModal.modal('hide');
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

                $restoreUserModal.on('hidden.bs.modal', () => {
                    $restoreUserForm.attr('action', restoreUserAction);
                });
            @endcan
            @endif
        })
    </script>
@endpush
