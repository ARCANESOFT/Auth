@section('header')
    <h1><i class="fa fa-fw fa-user"></i> Profile <small>{{ $user->full_name }}</small></h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
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
                        <tbody>
                            <tr>
                                <th>Username</th>
                                <td>{{ $user->username }}</td>
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
                                        <span class="label label-default">Disabled</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Created at</th>
                                <td><small>{{ $user->created_at }}</small></td>
                            </tr>
                            <tr>
                                <th>Updated at</th>
                                <td><small>{{ $user->updated_at }}</small></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a aria-expanded="false" href="#settings" data-toggle="tab">Settings</a>
                    </li>
                    <li>
                        <a aria-expanded="false" href="#password" data-toggle="tab">Password</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div id="settings" class="tab-pane active">
                        {{-- Settings --}}
                    </div>
                    <div id="password" class="tab-pane">
                        {!! Form::open(['route' => ['auth::foundation.profile.password.update', $user->hashed_id], 'method' => 'PUT', 'id' => 'updatePasswordForm', 'class' => 'form form-horizontal form-loading']) !!}
                            <div class="form-group {{ $errors->has('old_password') ? 'has-error' : '' }}">
                                {!! Form::label('old_password', 'Old password :', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('old_password', ['class' => 'form-control']) !!}
                                    @if ($errors->has('old_password'))
                                        <span class="text-red">{!! $errors->first('old_password') !!}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                {!! Form::label('password', 'New password :', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    @if ($errors->has('password'))
                                        <span class="text-red">{!! $errors->first('password') !!}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                                {!! Form::label('password_confirmation', 'Password Confirmation :', ['class' => 'col-sm-4 control-label']) !!}
                                <div class="col-sm-8">
                                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-red">{!! $errors->first('password_confirmation') !!}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group text-right">
                                <div class="col-xs-12">
                                    {!! Form::button('Update password', ['type' => 'submit', 'class' => 'btn btn-sm btn-warning']) !!}
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
