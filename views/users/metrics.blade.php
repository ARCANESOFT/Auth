@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-users"></i> @lang('Metrics') <small>@lang('Users')</small>
@endsection

@push('content-nav')
    <div class="mb-3 text-right">
        <a href="{{ route('admin::auth.users.metrics') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.users.metrics']) }}">@lang('Metrics')</a>
        <a href="{{ route('admin::auth.users.index') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.users.index']) }}">@lang('Users')</a>
        {{ arcanesoft\ui\action_link('add', route('admin::auth.users.create'))->size('sm') }}
    </div>
@endpush

@push('metrics')
@endpush

@section('content')
@endsection
