@section('header')
    <h1><i class="fa fa-fw fa-users"></i> {{ trans('auth::users.titles.users') }} <small>{{ trans('auth::users.titles.create-user') }}</small></h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin::auth.users.store', 'method' => 'POST', 'id' => 'createUserForm', 'class' => 'form form-loading']) }}
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ trans('auth::users.titles.new-user') }}</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('first_name', 'has-error') }}">
                                    {{ Form::label('first_name', trans('auth::users.attributes.first_name'), ['class' => 'control-label']) }}
                                    {{ Form::text('first_name', old('first_name'), ['class' => 'form-control']) }}
                                    @if ($errors->has('first_name'))
                                        <span class="text-red">{!! $errors->first('first_name') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('last_name', 'has-error') ? 'has-error' : ''}}">
                                    {{ Form::label('last_name', trans('auth::users.attributes.last_name'), ['class' => 'control-label']) }}
                                    {{ Form::text('last_name', old('last_name'), ['class' => 'form-control']) }}
                                    @if ($errors->has('last_name'))
                                        <span class="text-red">{!! $errors->first('last_name') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('username', 'has-error') }}">
                                    {{ Form::label('username', trans('auth::users.attributes.username'), ['class' => 'control-label']) }}
                                    {{ Form::text('username', old('username'), ['class' => 'form-control']) }}
                                    @if ($errors->has('username'))
                                        <span class="text-red">{!! $errors->first('username') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('email', 'has-error') }}">
                                    {{ Form::label('email', trans('auth::users.attributes.email'), ['class' => 'control-label']) }}
                                    {{ Form::email('email', old('email'), ['class' => 'form-control']) }}
                                    @if ($errors->has('email'))
                                        <span class="text-red">{!! $errors->first('email') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('password', 'has-error') }}">
                                    {{ Form::label('password', trans('auth::users.attributes.password'), ['class' => 'control-label']) }}
                                    {{ Form::password('password', ['class' => 'form-control']) }}
                                    @if ($errors->has('password'))
                                        <span class="text-red">{!! $errors->first('password') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->first('password_confirmation', 'has-error') }}">
                                    {{ Form::label('password_confirmation', trans('auth::users.attributes.password_confirmation'), ['class' => 'control-label']) }}
                                    {{ Form::password('password_confirmation', ['class' => 'form-control']) }}
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-red">{!! $errors->first('password_confirmation') !!}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        {{ link_to_route('admin::auth.users.index', 'Cancel', [], ['class' => 'btn btn-sm btn-default']) }}
                        <button type="submit" class="btn btn-sm btn-primary pull-right">
                            <i class="fa fa-fw fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @include('auth::admin.users._partials.roles-checkbox', ['old' => collect(old('roles', []))])
            </div>
        </div>
    {{ Form::close() }}
@endsection

@section('scripts')
@endsection
