@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-user-tag"></i> @lang('Metrics') <small>@lang('Roles')</small>
@endsection

@push('content-nav')
    <div class="mb-3 text-right">
        <a href="{{ route('admin::auth.roles.metrics') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.roles.metrics']) }}">@lang('Metrics')</a>
        <a href="{{ route('admin::auth.roles.index') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.roles.index']) }}">@lang('Roles')</a>
        {{ arcanesoft\ui\action_link('add', route('admin::auth.roles.create'))->size('sm') }}
    </div>
@endpush

@push('metrics')
@endpush

@section('content')
@endsection
