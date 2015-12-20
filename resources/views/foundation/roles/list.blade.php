@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> Roles <small>List of roles</small></h1>
@endsection

@section('content')
    <div class="box box-warning">
        <div class="box-header">
            <span class="label label-info" style="margin-right: 5px;">
                Total of roles : {{ $roles->total() }}
            </span>
            @if ($roles->hasPages())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $roles->currentPage(), 'last' => $roles->lastPage()]) }}
                </span>
            @endif

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
                        <th class="text-center" style="width: 60px;">Locked</th>
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
                                <span class="label label-{{ $role->isActive() ? 'success' : 'default'}}">
                                    <i class="fa fa-fw fa-{{ $role->isActive() ? 'check' : 'ban-o'}}"></i>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="label label-{{ $role->isLocked() ? 'danger' : 'success'}}">
                                    <i class="fa fa-fw fa-{{ $role->isLocked() ? 'lock' : 'unlock'}}"></i>
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                    <i class="fa fa-fw fa-search"></i>
                                </a>
                                @if ($role->isLocked())
                                    <a href="javascript:void(0);" class="btn btn-xs btn-warning" disabled="disabled" data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fa fa-fw fa-pencil"></i>
                                    </a>
                                    <a href="javascript:void(0);" class="btn btn-xs btn-danger" disabled="disabled" data-toggle="tooltip" data-original-title="Delete">
                                        <i class="fa fa-fw fa-trash-o"></i>
                                    </a>
                                @else
                                    <a href="{{ route('auth::foundation.roles.edit', [$role->hashed_id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                        <i class="fa fa-fw fa-pencil"></i>
                                    </a>
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

        @if ($roles->hasPages())
            <div class="box-footer clearfix">
                {!! $roles->render() !!}
            </div>
        @endif
    </div>
@endsection

@section('scripts')
@endsection
