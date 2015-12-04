@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> Roles <small>List of roles</small></h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <span class="label label-info">
                Total of roles : {{ $roles->total() }}
            </span>
            <div class="box-tools">
                <a href="{{ route('auth::foundation.roles.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th class="text-center">N° Users</th>
                        <th class="text-center">N° Permissions</th>
                        <th class="text-center" style="width: 60px;">Status</th>
                        <th class="text-right" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr>
                            <td>{{ $role->name }}</td>
                            <td>
                                <span class="label label-primary">{{ $role->slug }}</span>
                            </td>
                            <td>{{ $role->description }}</td>
                            <td class="text-center">
                                <span class="label label-{{ $role->users->count() ? 'info' : 'default' }}">
                                    {{ $role->users->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="label label-{{ $role->permissions->count() ? 'info' : 'default' }}">
                                    {{ $role->permissions->count() }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if ($role->isActive())
                                    <span class="label label-success">
                                        <i class="fa fa-fw fa-check"></i>
                                    </span>
                                @else
                                    <span class="label label-default">
                                        <i class="fa fa-fw fa-ban-o"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                    <i class="fa fa-fw fa-search"></i>
                                </a>
                                <a href="{{ route('auth::foundation.roles.edit', [$role->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="edit">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </a>
                                @if ($role->isLocked())
                                    <a href="javascript:void(0);" class="btn btn-xs btn-danger" disabled="disabled"  data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                @else
                                    <a href="#" class="btn btn-xs btn-danger" data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="box-footer clearfix">
            @if ($roles->total())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $roles->currentPage(), 'last' => $roles->lastPage()]) }}
                </span>
            @endif

            {!! $roles->render() !!}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
