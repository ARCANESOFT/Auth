@section('header')
    <h1><i class="fa fa-fw fa-users"></i> Users <small>List of users</small></h1>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <span class="label label-info">
                Total of users : {{ $users->total() }}
            </span>
            <div class="box-tools">
                <a href="{{ route('auth::foundation.users.create') }}" class="btn btn-xs btn-primary" data-toggle="tooltip" data-original-title="Add">
                    <i class="fa fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="box-body no-padding">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 40px;"></th>
                        <th>Username</th>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th class="text-center" style="width: 60px;">Status</th>
                        <th class="text-right" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="text-center">
                                {!! Html::image($user->gravatar, $user->username, ['class' => 'img-circle', 'style' => 'width: 24px;']) !!}
                            </td>
                            <td>
                                {{ $user->username }}
                            </td>
                            <td>
                                {{ $user->full_name }}
                            </td>
                            <td>
                                {{ $user->email }}
                            </td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="label label-primary">
                                        {{  $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="text-center">
                                @if ($user->isActive())
                                    <span class="label label-success">
                                        <i class="fa fa-check"></i>
                                    </span>
                                @else
                                    <span class="label label-default">
                                        <i class="fa fa-ban"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('auth::foundation.users.show', [$user->id]) }}" class="btn btn-xs btn-info" data-toggle="tooltip" data-original-title="Show">
                                    <i class="fa fa-fw fa-search"></i>
                                </a>
                                <a href="{{ route('auth::foundation.users.edit', [$user->id]) }}" class="btn btn-xs btn-warning" data-toggle="tooltip" data-original-title="Edit">
                                    <i class="fa fa-fw fa-pencil"></i>
                                </a>
                                @if ($user->isAdmin())
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
            @if ($users->total())
                <span class="label label-info">
                    {{ trans('foundation::pagination.pages', ['current' => $users->currentPage(), 'last' => $users->lastPage()]) }}
                </span>
            @endif

            {!! $users->render() !!}
        </div>
    </div>
@endsection

@section('scripts')
@endsection
