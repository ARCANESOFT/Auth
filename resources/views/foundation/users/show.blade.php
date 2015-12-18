@section('header')
    <h1><i class="fa fa-fw fa-users"></i> Users <small>User details</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-5">
            <div class="box box-widget widget-user-2">
                <div class="widget-user-header bg-blue">
                    <div class="widget-user-image">
                        {!! Html::image($user->gravatar, $user->full_name, ['class' => 'img-circle']) !!}
                    </div>
                    <h3 class="widget-user-username">{{ $user->full_name }}</h3>
                    <h5 class="widget-user-desc">{{ $user->since_date }}</h5>
                </div>
                <div class="box-body">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>First Name</th>
                                <td>{{ $user->first_name }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $user->last_name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @if ($user->isAdmin())
                                        <span class="label label-warning" style="margin-right: 5px;">
                                            <i class="fa fa-fw fa-star"></i> SUPER ADMIN
                                        </span>
                                    @endif

                                    @if ($user->isActive())
                                        <span class="label label-success">Acitve</span>
                                    @else
                                        <span class="label label-success">Disabled</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td>{{ $user->created_at }}</td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td>{{ $user->updated_at }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="box-footer">
                    <a href="#" class="btn btn-xs btn-warning">
                        <i class="fa fa-fw fa-pencil"></i> Edit
                    </a>
                    @if ($user->isAdmin())
                        <a href="javascript:void(0);" class="btn btn-xs btn-danger" disabled="disabled"  data-toggle="tooltip" data-original-title="Delete">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </a>
                    @else
                        <a href="#" class="btn btn-xs btn-danger" data-toggle="tooltip" data-original-title="Delete">
                            <i class="fa fa-fw fa-trash-o"></i> Delete
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-7">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Roles</h3>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-condensed">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th class="text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->roles as $role)
                                <tr>
                                    <td><span class="label label-primary">{{ $role->name }}</span></td>
                                    <td>{{ $role->description }}</td>
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
