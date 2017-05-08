@section('header')
    <h1><i class="fa fa-fw fa-lock"></i> {{ trans('auth::roles.titles.roles') }} <small>{{ trans('auth::roles.titles.create-role') }}</small></h1>
@endsection

@section('content')
    {{ Form::open(['route' => 'admin::auth.roles.store', 'method' => 'POST', 'id' => 'createRoleForm', 'class' => 'form form-loading']) }}
        <div class="box box-warning">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('auth::roles.titles.new-role') }}</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('name', 'has-error') }}">
                            {{ Form::label('name', trans('auth::roles.attributes.name'), ['class' => 'control-label']) }}
                            {{ Form::text('name', old('name'), ['class' => 'form-control']) }}
                            @if ($errors->has('name'))
                                <span class="text-red">{!! $errors->first('name') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('slug', 'has-error') }}">
                            {{ Form::label('slug', trans('auth::roles.attributes.slug'), ['class' => 'control-label']) }}
                            {{ Form::text('slug', old('slug'), ['class' => 'form-control']) }}
                            @if ($errors->has('slug'))
                                <span class="text-red">{!! $errors->first('slug') !!}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group {{ $errors->first('description', 'has-error') }}">
                            {{ Form::label('description', trans('auth::roles.attributes.description'), ['class' => 'control-label']) }}
                            {{ Form::text('description', old('description'), ['class' => 'form-control']) }}
                            @if ($errors->has('description'))
                                <span class="text-red">{!! $errors->first('description') !!}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
                {{ ui_link('cancel', route('admin::auth.roles.index')) }}
                {{ ui_button('create', 'submit')->appendClass('pull-right')->withLoadingText() }}
            </div>
        </div>

        @include('auth::admin.roles._partials.permissions-checkbox', ['old' => old('permissions', collect())])
    {{ Form::close() }}
@endsection
