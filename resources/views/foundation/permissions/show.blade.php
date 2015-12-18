@section('header')
    <h1><i class="fa fa-fw fa-check-circle"></i> Permissions <small>Permission details</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-5">
            <div class="box box-success">
                <div class="box-header">
                    <h3 class="box-title">Permission details</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Name</th>
                                <td>{{ $permission->name }}</td>
                            </tr>
                            <tr>
                                <th>Description</th>
                                <td>{{ $permission->description }}</td>
                            </tr>
                            <tr>
                                <th>Slug</th>
                                <td>
                                    <span class="label label-success">
                                        {{ $permission->slug }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Roles</th>
                                <td>
                                    <span class="label label-{{ $permission->roles->count() ? 'info' : 'default'}}">
                                        {{ $permission->roles->count() }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td><small>{{ $permission->created_at }}</small></td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td><small>{{ $permission->updated_at }}</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Roles</h3>
                </div>
                <div class="box-body no-padding">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-center">Users</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($permission->roles as $role)
                                <tr>
                                    <td>
                                        <span class="label label-primary">{{ $role->name }}</span>
                                    </td>
                                    <td>{{ $role->description }}</td>
                                    <td class="text-center">
                                        <span class="label label-{{ $role->users->count() ? 'info' : 'default'}}">
                                            {{ $role->users->count() }}
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('auth::foundation.roles.show', [$role->hashed_id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                            <i class="fa fa-fw fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
