@section('header')
    <h1><i class="fa fa-fw fa-bar-chart"></i> Statistics</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-sm-6 col-md-3">
            @include(Arcanesoft\Auth\ViewComposers\Dashboard\UsersCountComposer::VIEW)
        </div>
        <div class="col-sm-6 col-md-3">
            @include(Arcanesoft\Auth\ViewComposers\Dashboard\RolesCountComposer::VIEW)
        </div>
        <div class="col-sm-6 col-md-3">
            @include(Arcanesoft\Auth\ViewComposers\Dashboard\PermissionsCountComposer::VIEW)
        </div>
    </div>

    @include(\Arcanesoft\Auth\ViewComposers\Dashboard\LatestThirtyDaysCreatedUsersComposer::VIEW)
@endsection

@section('scripts')
@endsection
