<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">Permissions Group</h3>
    </div>
    @if ($permission->hasGroup())
        <?php
            /** @var  \Arcanesoft\Auth\Models\PermissionsGroup  $group */
            $group = $permission->group->load('permissions');
        ?>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed no-margin">
                    <tbody>
                        <tr>
                            <th>Name :</th>
                            <td><span class="label label-primary">{{ $group->name }}</span></td>
                        </tr>
                        <tr>
                            <th>Slug :</th>
                            <td><span class="label label-primary">{{ $group->slug }}</span></td>
                        </tr>
                        <tr>
                            <th>Description :</th>
                            <td>{{ $group->description }}</td>
                        </tr>
                        <tr>
                            <th>N° Permissions :</th>
                            <td>
                                <span class="label label-{{ $group->permissions->count() ? 'info' : 'default' }}">
                                    {{ $group->permissions->count() }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Created at :</th>
                            <td><small>{{ $group->created_at }}</small></td>
                        </tr>
                        <tr>
                            <th>Updated at :</th>
                            <td><small>{{ $group->updated_at }}</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            {{ link_to_route('admin::auth.permissions.group', 'Show all permissions', [$group->hashed_id], ['class' => 'btn btn-sm btn-default btn-block']) }}
        </div>
    @else

        <div class="box-body no-padding">
            <table class="table table-condensed no-margin">
                <tbody>
                    <tr>
                        <th>Name :</th>
                        <td><span class="label label-default">Custom</span></td>
                    </tr>
                    <tr>
                        <th>Description :</th>
                        <td>This permission isn't belonging to any group of permissions.</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            {{ link_to_route('admin::auth.permissions.group', 'Show all permissions', [hasher()->encode(0)], ['class' => 'btn btn-sm btn-default btn-block']) }}
        </div>
    @endif
</div>
