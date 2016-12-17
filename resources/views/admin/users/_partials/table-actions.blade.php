@can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_SHOW)
    <a href="{{ route('admin::auth.users.show', [$user->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
        <i class="fa fa-fw fa-search"></i>
    </a>
@endcan

@can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_UPDATE)
    <a href="{{ route('admin::auth.users.edit', [$user->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
        <i class="fa fa-fw fa-pencil"></i>
    </a>

    @if ($user->trashed())
        <a href="#restoreUserModal" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Restore" data-user-id="{{ $user->hashed_id }}" data-user-name="{{ $user->username }}">
            <i class="fa fa-fw fa-reply"></i>
        </a>
    @endif

    @if ($user->isAdmin())
        @if ($user->isActive())
            <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled" data-toggle="tooltip" data-original-title="Disable">
                <i class="fa fa-fw fa-power-off"></i>
            </a>
        @else
            <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled" data-toggle="tooltip" data-original-title="Enable">
                <i class="fa fa-fw fa-power-off"></i>
            </a>
        @endif
    @else
        @if ($user->isActive())
            <a href="#activateUserModal" class="btn btn-xs btn-inverse" data-toggle="tooltip" data-original-title="Disable" data-user-id="{{ $user->hashed_id }}" data-user-name="{{ $user->username }}" data-user-status="enabled">
                <i class="fa fa-fw fa-power-off"></i>
            </a>
        @else
            <a href="#activateUserModal" class="btn btn-xs btn-success" data-toggle="tooltip" data-original-title="Enable" data-user-id="{{ $user->hashed_id }}" data-user-name="{{ $user->username }}" data-user-status="disabled">
                <i class="fa fa-fw fa-power-off"></i>
            </a>
        @endif
    @endif
@endcan

@can(Arcanesoft\Auth\Policies\UsersPolicy::PERMISSION_DELETE)
    @if ($user->isAdmin())
        <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled" data-toggle="tooltip" data-original-title="Delete">
            <i class="fa fa-fw fa-trash-o"></i>
        </a>
    @else
        <a href="#deleteUserModal" class="btn btn-xs btn-danger" data-toggle="tooltip" data-original-title="Delete" data-user-id="{{ $user->hashed_id }}" data-user-name="{{ $user->username }}">
            <i class="fa fa-fw fa-trash-o"></i>
        </a>
    @endif
@endcan
