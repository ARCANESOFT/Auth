@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> Roles <small>Edit a role</small></h1>
@endsection

@section('content')
    {!! Form::open(['route' => ['auth::foundation.roles.update', $role->hashed_id], 'method' => 'PUT', 'id' => 'updateRoleForm', 'class' => 'form form-loading']) !!}
        <div class="row">
            <div class="col-md-4">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Edit Role</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : ''}}">
                            {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
                            {!! Form::text('name', old('name', $role->name), ['class' => 'form-control']) !!}
                            @if ($errors->has('name'))
                                <span class="text-red">{!! $errors->first('name') !!}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('slug') ? 'has-error' : ''}}">
                            {!! Form::label('slug', 'Slug', ['class' => 'control-label']) !!}
                            {!! Form::text('slug', old('slug', $role->slug), ['class' => 'form-control']) !!}
                            @if ($errors->has('slug'))
                                <span class="text-red">{!! $errors->first('slug') !!}</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('description') ? 'has-error' : ''}}">
                            {!! Form::label('description', 'Description', ['class' => 'control-label']) !!}
                            {!! Form::text('description', old('description', $role->description), ['class' => 'form-control']) !!}
                            @if ($errors->has('description'))
                                <span class="text-red">{!! $errors->first('description') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="box-footer text-right">
                        <button type="submit" class="btn btn-sm btn-warning" data-loading-text="Loading&hellip;">
                            <i class="fa fa-fw fa-pencil"></i> Update
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                @include('auth::foundation.roles._partials.permissions-checkbox', ['old' => old('permissions', $role->permissions->lists('id')->toArray())])
            </div>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
@endsection
