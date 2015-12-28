<a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
    <i class="fa fa-fw fa-search"></i>
</a>
@if ($role->isLocked())
    <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled" data-toggle="tooltip" data-original-title="Edit">
        <i class="fa fa-fw fa-pencil"></i>
    </a>
    @if ($role->isActive())
        <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled" data-toggle="tooltip" data-original-title="Disable">
            <i class="fa fa-fw fa-power-off"></i>
        </a>
    @else
        <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled" data-toggle="tooltip" data-original-title="Activate">
            <i class="fa fa-fw fa-power-off"></i>
        </a>
    @endif
    <a href="javascript:void(0);" class="btn btn-xs btn-default" disabled="disabled" data-toggle="tooltip" data-original-title="Delete">
        <i class="fa fa-fw fa-trash-o"></i>
    </a>
@else
    <a href="{{ route('auth::foundation.roles.edit', [$role->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
        <i class="fa fa-fw fa-pencil"></i>
    </a>
    @if ($role->isActive())
        <a href="#activateRoleModal" class="btn btn-xs btn-inverse" data-toggle="tooltip" data-original-title="Disable" data-role-id="{{ $role->hashed_id }}" data-role-name="{{ $role->name }}" data-role-status="enabled">
            <i class="fa fa-fw fa-power-off"></i>
        </a>
    @else
        <a href="#activateRoleModal" class="btn btn-xs btn-success" data-toggle="tooltip" data-original-title="Activate" data-role-id="{{ $role->hashed_id }}" data-role-name="{{ $role->name }}" data-role-status="disabled">
            <i class="fa fa-fw fa-power-off"></i>
        </a>
    @endif
    <a href="#deleteRoleModal" class="btn btn-xs btn-danger" data-toggle="tooltip" data-original-title="Delete" data-role-id="{{ $role->hashed_id }}" data-role-name="{{ $role->name }}">
        <i class="fa fa-fw fa-trash-o"></i>
    </a>
@endif
