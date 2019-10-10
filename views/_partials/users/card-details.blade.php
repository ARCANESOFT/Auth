<?php /** @var  Arcanesoft\Auth\Models\User  $user */ ?>

<div class="card card-borderless shadow-sm mb-3">
    <div class="card-body d-flex justify-content-center p-3">
        <div class="avatar avatar-xl">
            {{ html()->image($user->avatar, $user->full_name, []) }}
        </div>
    </div>
    <table class="table table-md mb-0">
        <tbody>
            <tr>
                <th>{{ __('Full Name') }} :</th>
                <td class="text-right">{{ $user->full_name }}</td>
            </tr>
            <tr>
                <th>{{ __('Email') }} :</th>
                <td class="text-right">
                @if ($user->hasVerifiedEmail())
                    <i class="far fa-check-circle text-primary" data-toggle="tooltip" data-placement="top" title="{{ __('Verified') }}"></i>
                @endif
                    {{ $user->email }}
                </td>
            </tr>
            @if ($user->hasVerifiedEmail())
                <tr>
                    <th>{{ __('Email Verified at') }} :</th>
                    <td class="text-right">
                        <small class="text-muted">{{ $user->email_verified_at }}</small>
                    </td>
                </tr>
            @endif
            <tr>
                <th>{{ __('Status') }} :</th>
                <td class="text-right">
                    @if ($user->isActive())
                        <span class="badge badge-outline-success">
                            <i class="fa fa-check"></i> {{ __('Activated') }}
                        </span>
                    @else
                        <span class="badge badge-outline-secondary">
                            <i class="fa fa-ban"></i> {{ __('Deactivated') }}
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
                <th>{{ __('Last activity') }} :</th>
                <td class="text-right"><small class="text-muted">3 minutes ago</small></td>
            </tr>
            <tr>
                <th>{{ __('Created at') }} :</th>
                <td class="text-right"><small class="text-muted">{{ $user->created_at }}</small></td>
            </tr>
            <tr>
                <th>{{ __('Updated at') }} :</th>
                <td class="text-right"><small class="text-muted">{{ $user->updated_at }}</small></td>
            </tr>
        </tbody>
    </table>
    <div class="card-footer text-right px-2">
        @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('show'), $user)
            {{ ui\action_link('show', route('admin::auth.users.show', [$user->hashed_id]))->size('sm') }}
        @endcan

        @can(Arcanesoft\Auth\Policies\UsersPolicy::ability('update'), $user)
            {{ ui\action_link('edit', route('admin::auth.users.edit', [$user->hashed_id]))->size('sm') }}
        @endcan
    </div>
</div>
