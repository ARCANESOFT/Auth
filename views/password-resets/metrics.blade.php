@extends(arcanesoft\foundation()->template())

@section('page-title')
    <i class="fa fa-fw fa-users"></i> @lang('Metrics') <small>@lang('Password Resets')</small>
@endsection

@push('content-nav')
    <div class="mb-3 text-right">
        <a href="{{ route('admin::auth.password-resets.metrics') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.password-resets.metrics']) }}">@lang('Metrics')</a>
        <a href="{{ route('admin::auth.password-resets.index') }}" class="btn btn-sm btn-secondary {{ active(['admin::auth.password-resets.index']) }}">@lang('Password Resets')</a>
    </div>
@endpush

@push('metrics')
@endpush

@section('content')
@endsection
