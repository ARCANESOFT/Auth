@section('header')
    <h1><i class="fa fa-fw fa-bar-chart"></i> {{ trans('auth::dashboard.titles.statistics') }}</h1>
@endsection

@section('content')
    @include('auth::admin._composers.dashboard')
@endsection

@section('scripts')
@endsection
