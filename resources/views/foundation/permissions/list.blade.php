@section('header')
    <h1><i class="fa fa-fw fa-check-circle"></i> Permissions <small>List of permissions</small></h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <span class="label label-info" style="margin-right: 5px;">
                Total of permissions : {{ $permissions->total() }}
            </span>
            @if ($permissions->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $permissions->currentPage(), 'last' => $permissions->lastPage()]) }}
                </span>
            @endif

            <div class="box-tools">
                <div class="dropdown pull-right">
                    <button class="btn btn-sm btn-default dropdown-toggle" type="button" id="groupFilter" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Group <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="groupFilter">
                        <li>{{ link_to_route('auth::foundation.permissions.index', 'All') }}</li>
                        @foreach ($groupFilters as $groupFilter)
                        <li>{!! $groupFilter !!}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="box-body no-padding">
            <div class="table-responsive">
                <table class="table table-condensed table-hover no-margin">
                    <thead>
                        <tr>
                            <th>Group</th>
                            <th>Slug</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th class="text-center">N° Roles</th>
                            <th class="text-right" style="width: 80px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($permissions->count())
                            @foreach ($permissions as $permission)
                            <tr>
                                <td>
                                    @if ($permission->hasGroup())
                                        <span class="label label-primary">{{ $permission->group->name }}</span>
                                    @else
                                        <span class="label label-default">Custom</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="label label-success">{{ $permission->slug }}</span>
                                </td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->description }}</td>
                                <td class="text-center">
                                    <span class="label label-{{ $permission->roles->count() ? 'info' : 'default'}}">
                                        {{ $permission->roles->count() }}
                                    </span>
                                </td>
                                <td class="text-right">
                                    @can(Arcanesoft\Auth\Policies\PermissionsPolicy::PERMISSION_SHOW)
                                        <a href="{{ route('auth::foundation.permissions.show', [$permission->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                            <i class="fa fa-fw fa-search"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">
                                    <span class="label label-default">The permission list is empty.</span>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        @if ($permissions->hasPages())
            <div class="box-footer clearfix">
                {!! $permissions->render() !!}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
