@section('header')
    <h1><i class="fa fa-fw fa-users"></i> Users <small>Create a user</small></h1>
@endsection

@section('content')
    {!! Form::open(['route' => 'auth::foundation.users.store', 'method' => 'POST', 'id' => 'createUserForm', 'class' => 'form form-loading']) !!}
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">New User</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('username') ? 'has-error' : ''}}">
                                    {!! Form::label('username', 'Username') !!}
                                    {!! Form::text('username', old('username'), ['class' => 'form-control']) !!}
                                    @if ($errors->has('username'))
                                        <span class="text-red">{!! $errors->first('username') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('email') ? 'has-error' : ''}}">
                                    {!! Form::label('email', 'Email') !!}
                                    {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}
                                    @if ($errors->has('email'))
                                        <span class="text-red">{!! $errors->first('email') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('first_name') ? 'has-error' : ''}}">
                                    {!! Form::label('first_name', 'First Name') !!}
                                    {!! Form::text('first_name', old('first_name'), ['class' => 'form-control']) !!}
                                    @if ($errors->has('first_name'))
                                        <span class="text-red">{!! $errors->first('first_name') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('last_name') ? 'has-error' : ''}}">
                                    {!! Form::label('last_name', 'Last Name') !!}
                                    {!! Form::text('last_name', old('last_name'), ['class' => 'form-control']) !!}
                                    @if ($errors->has('last_name'))
                                        <span class="text-red">{!! $errors->first('last_name') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('password') ? 'has-error' : ''}}">
                                    {!! Form::label('password', 'Password') !!}
                                    {!! Form::password('password', ['class' => 'form-control']) !!}
                                    @if ($errors->has('password'))
                                        <span class="text-red">{!! $errors->first('password') !!}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : ''}}">
                                    {!! Form::label('password_confirmation', 'Password confirmation') !!}
                                    {!! Form::password('password_confirmation', ['class' => 'form-control']) !!}
                                    @if ($errors->has('password_confirmation'))
                                        <span class="text-red">{!! $errors->first('password_confirmation') !!}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <a href="{{ route('auth::foundation.users.index') }}" class="btn btn-sm btn-default">
                            Cancel
                        </a>
                        <button type="submit" class="btn btn-sm btn-primary pull-right">
                            <i class="fa fa-fw fa-plus"></i> Add
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                @include('auth::foundation.users._partials.roles-checkbox', ['old' => old('roles', [])])
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
@endsection
