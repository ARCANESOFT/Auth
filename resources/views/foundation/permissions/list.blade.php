@section('header')
    <h1><i class="fa fa-fw fa-check-circle"></i> Permissions <small>List of permissions</small></h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header">
            <span class="label label-info">
                Total of permissions : {{ $permissions->total() }}
            </span>

            <div class="box-tools">
                @if ($permissions->hasPages())
                    <span class="label label-info">
                        {{ trans('foundation::pagination.pages', ['current' => $permissions->currentPage(), 'last' => $permissions->lastPage()]) }}
                    </span>
                @endif
            </div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Slug</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th class="text-center">N° Roles</th>
                        <th class="text-right" style="width: 80px;">Actions</th>
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
                            <td class="text-center">
                                <span class="label label-{{ $permission->roles->count() ? 'info' : 'default'}}">
                                    {{ $permission->roles->count() }}
                                </span>
                            </td>
                            <td class="text-right">
                                <a href="{{ route('auth::foundation.permissions.show', [$permission->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                    <i class="fa fa-fw fa-search"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
