<div class="box box-default">
    <div class="box-header">
        <h3 class="box-title">{{ trans('auth::permission-groups.titles.permission-group') }}</h3>
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
                            <th>{{ trans('auth::permission-groups.attributes.name') }} :</th>
                            <td><span class="label label-primary">{{ $group->name }}</span></td>
                        </tr>
                        <tr>
                            <th>{{ trans('auth::permission-groups.attributes.slug') }} :</th>
                            <td><span class="label label-primary">{{ $group->slug }}</span></td>
                        </tr>
                        <tr>
                            <th>{{ trans('auth::permission-groups.attributes.description') }} :</th>
                            <td>{{ $group->description }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('auth::permissions.titles.permissions') }} :</th>
                            <td>{{ label_count($group->permissions->count()) }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('core::generals.created_at') }} :</th>
                            <td><small>{{ $group->created_at }}</small></td>
                        </tr>
                        <tr>
                            <th>{{ trans('core::generals.updated_at') }} :</th>
                            <td><small>{{ $group->updated_at }}</small></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer">
            {{ link_to_route('admin::auth.permissions.group', trans('auth::permission-groups.actions.show-permissions'), [$group->hashed_id], ['class' => 'btn btn-sm btn-default btn-block']) }}
        </div>
    @else
        <div class="box-body no-padding">
            <table class="table table-condensed no-margin">
                <tbody>
                    <tr>
                        <th>{{ trans('auth::permission-groups.attributes.name') }} :</th>
                        <td><span class="label label-default">{{ trans('auth::permission-groups.custom') }}</span></td>
                    </tr>
                    <tr>
                        <th>{{ trans('auth::permission-groups.attributes.description') }} :</th>
                        <td>{{ trans('auth::permissions.has-no-group') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            {{ link_to_route('admin::auth.permissions.group', 'Show all permissions', [hasher()->encode(0)], ['class' => 'btn btn-sm btn-default btn-block']) }}
        </div>
    @endif
</div>
