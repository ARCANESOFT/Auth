@section('header')
    <h1><i class="fa fa-fw fa-check-circle"></i> Permissions <small>List of permissions</small></h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <span class="label label-info">
                Total of roles : {{ $permissions->total() }}
            </span>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Slug</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Roles</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $permission)
                        <tr>
                            <td>
                                <span class="label label-success">{{ $permission->slug }}</span>
                            </td>
                            <td>{{ $permission->name }}</td>
                            <td>{{ $permission->description }}</td>
                            <td>
                                @foreach ($permission->roles as $role)
                                    <span class="label label-primary" style="margin-right: 5px;">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('auth::foundation.permissions.show', [$permission->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                    <i class="fa fa-fw fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix">
            @if ($permissions->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $permissions->currentPage(), 'last' => $permissions->lastPage()]) }}
                </span>
            @endif

            {!! $permissions->render() !!}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
