<div class="box box-warning">
    <div class="box-header with-border">
        <h3 class="box-title">Roles</h3>
    </div>
    <div class="box-body no-padding">
        <div class="table-responsive">
            <table class="table table-condensed no-margin">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($user->roles->count())
                        @foreach ($user->roles as $role)
                        <tr>
                            <td><span class="label label-primary">{{ $role->name }}</span></td>
                            <td>{{ $role->description }}</td>
                            <td class="text-right">
                                @can(Arcanesoft\Auth\Policies\RolesPolicy::PERMISSION_SHOW)
                                    <a href="{{ route('admin::auth.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                        <i class="fa fa-fw fa-search"></i>
                                    </a>
                                @endcan
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="3" class="text-center">
                                <span class="label label-default">This user has no roles.</span>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
