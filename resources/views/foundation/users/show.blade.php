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
                    <h5 class="widget-user-desc">Member since {{ $user->created_at->toFormattedDateString() }}</h5>
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
                    <a href="#" class="btn btn-xs btn-danger">
                        <i class="fa fa-fw fa-trash-o"></i> Delete
                    </a>
                </div>
            </div>
        </div>
        <div class="col-sm-7">
        </div>
    </div>
@endsection

@section('scripts')
@endsection
