@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-users"></i> @lang("User's details")
@endsection

<?php
/** @var  Arcanesoft\Auth\Models\User  $user */
?>

@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-body d-flex justify-content-center p-3">
                    <div class="avatar avatar-xl">
                        {{ html()->image($user->avatar, $user->full_name, []) }}
                    </div>
                </div>
                <table class="table table-md mb-0">
                    <tbody>
                        <tr>
                            <th>@lang('Full Name') :</th>
                            <td class="text-right">{{ $user->full_name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Email') :</th>
                            <td class="text-right">
                                @if ($user->hasVerifiedEmail())
                                    <i class="far fa-check-circle text-primary" data-toggle="tooltip" data-placement="top" title="{{ __('Verified') }}"></i>
                                @endif
                                {{ $user->email }}
                            </td>
                        </tr>
                        @if ($user->hasVerifiedEmail())
                        <tr>
                            <th>@lang('Email Verified at') :</th>
                            <td class="text-right">
                                <small class="text-muted">{{ $user->email_verified_at }}</small>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <th>@lang('Status') :</th>
                            <td class="text-right">
                                @if ($user->isActive())
                                    <span class="badge badge-outline-success">
                                        <i class="fa fa-check"></i> @lang('Activated')
                                    </span>
                                @else
                                    <span class="badge badge-outline-secondary">
                                        <i class="fa fa-ban"></i> @lang('Deactivated')
                                    </span>
                                @endif
                                @if ($user->isAdmin())
                                    <span class="badge badge-outline-warning" data-toggle="tooltip" data-placement="top" title="{{ __('Administrator') }}">
                                        <i class="fas fa-crown"></i>
                                    </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Last activity') :</th>
                            <td class="text-right"><small class="text-muted">{{ $user->last_activity }}</small></td>
                        </tr>
                        <tr>
                            <th>@lang('Created at') :</th>
                            <td class="text-right"><small class="text-muted">{{ $user->created_at }}</small></td>
                        </tr>
                        <tr>
                            <th>@lang('Updated at') :</th>
                            <td class="text-right"><small class="text-muted">{{ $user->updated_at }}</small></td>
                        </tr>
                        @if ($user->trashed())
                            <tr>
                                <th>@lang('Deleted at') :</th>
                                <td class="text-right"><small class="text-muted">{{ $user->deleted_at }}</small></td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <div class="card-footer text-right px-2">
                    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('impersonate'), $user)
                        <a href="{{ route('admin::auth.users.impersonate', [$user]) }}" class="btn btn-sm btn-dark">
                            <i class="fas fa-fw fa-mask"></i> @lang('Impersonate')
                        </a>
                    @endcan

                    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('update'), $user)
                        {{ arcanesoft\ui\action_link('edit', route('admin::auth.users.edit', [$user]))->size('sm') }}
                    @endcan

                    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('activate'), $user)
                        {{ arcanesoft\ui\action_button($user->isActive() ? 'deactivate' : 'activate')->attribute('onclick', "window.Foundation.\$emit('auth::users.activate')")->size('sm')->setDisabled($user->isSuperAdmin()) }}
                    @endcan

                    @if ($user->trashed())
                        @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('restore'), $user)
                        {{ arcanesoft\ui\action_button('restore')->attribute('onclick', "window.Foundation.\$emit('auth::users.restore')")->size('sm') }}
                        @endcan
                    @endif

                    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('delete'), $user)
                        {{ arcanesoft\ui\action_button('delete')->attribute('onclick', "window.Foundation.\$emit('auth::users.delete')")->size('sm')->setDisabled($user->isNotDeletable()) }}
                    @endcan
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card card-borderless shadow-sm mb-3">
                <div class="card-header p-2">@lang('Roles')</div>
                <table class="table table-hover table-md mb-0">
                    <thead>
                        <tr>
                            <th>@lang('Name')</th>
                            <th>@lang('Description')</th>
                            <th class="text-right">@lang('Actions')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($user->roles as $role)
                            <?php /** @var  Arcanesoft\Auth\Models\Role  $role */ ?>
                            <tr>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td class="text-right">
                                    {{ arcanesoft\ui\action_link_icon('show', route('admin::auth.roles.show', [$role]))->size('sm') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">@lang('The list is empty !')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    {{-- ACIVATE MODAL --}}
    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('activate'), $user)
        <div class="modal modal-danger fade" id="activate-user-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="activateUserTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.users.activate', $user], 'method' => 'PUT', 'id' => 'activate-user-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="activateUserTitle">@lang($user->isActive() ? 'Deactivate User' : 'Activate User')</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div id="activateUserMessage" class="modal-body">
                            @lang($user->isActive() ? 'Are you sure you want to deactivate user ?' : 'Are you sure you want to activate user ?')
                        </div>
                        <div class="modal-footer justify-content-between">
                            {{ arcanesoft\ui\action_button('cancel')->attribute('data-dismiss', 'modal') }}
                            {{ arcanesoft\ui\action_button($user->isActive() ? 'deactivate' : 'activate')->submit() }}
                        </div>
                    </div>
                {{ form()->close() }}
            </div>
        </div>
    @endcan

    {{-- DELETE MODAL --}}
    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('delete'), $user)
        <div class="modal modal-danger fade" id="delete-user-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="deleteUserTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.users.delete', $user], 'method' => 'DELETE', 'id' => 'delete-user-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="deleteUserTitle">@lang('Delete User')</h4>
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
    @if ($user->trashed())
    @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('restore'), $user)
        <div class="modal modal-danger fade" id="restore-user-modal" data-backdrop="static"
             tabindex="-1" role="dialog" aria-labelledby="restoreUserTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                {{ form()->open(['route' => ['admin::auth.users.restore', ':id'], 'method' => 'PUT', 'id' => 'restore-user-form']) }}
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="restoreUserTitle">@lang('Restore User')</h4>
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
    @endif
@endpush

@push('scripts')
    <script>
        window.ready(() => {
            {{-- ACTIVATE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('activate'), $user)
            let $activateUserModal = $('div#activate-user-modal'),
                $activateUserForm  = $('form#activate-user-form');

            window.Foundation.$on('auth::users.activate', () => {
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
                         console.log(error);
                         submitBtn.reset();
                     });

                return false;
            });
            @endcan

            {{-- DELETE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('delete'), $user)
            let $deleteUserModal = $('div#delete-user-modal'),
                $deleteUserForm  = $('form#delete-user-form');

            window.Foundation.$on('auth::users.delete', () => {
                $deleteUserModal.modal('show');
            });

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
                              @if ($user->trashed())
                                  location.replace("{{ route('admin::auth.users.index') }}");
                              @else
                                  location.reload();
                              @endif
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
            @endcan

            {{-- RESTORE SCRIPT --}}
            @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('restore'), $user)
            @if ($user->trashed())
            let $restoreUserModal = $('div#restore-user-modal'),
                $restoreUserForm  = $('form#restore-user-form');

            window.Foundation.$on('auth::users.restore', () => {
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
            @endif
            @endcan
        })
    </script>
@endpush

