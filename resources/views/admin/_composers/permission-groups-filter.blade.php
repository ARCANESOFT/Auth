<div class="dropdown pull-right">
    <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="groupFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Group <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" aria-labelledby="groupFilter">
        <li>{{ link_to_route('admin::auth.permissions.index', 'All') }}</li>
        @foreach ($permissionGroupsFilters as $group)
            <li>{{ link_to_route('admin::auth.permissions.group', $group['name'], $group['params']) }}</li>
        @endforeach
    </ul>
</div>
