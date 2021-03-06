@can(Arcanesoft\Auth\Policies\DashboardPolicy::PERMISSION_STATS)
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
        <div class="col-sm-6 col-md-3">
            @include(Arcanesoft\Auth\ViewComposers\Dashboard\OnlineUsersCountComposer::VIEW)
        </div>
    </div>

    @include(Arcanesoft\Auth\ViewComposers\Dashboard\LatestThirtyDaysCreatedUsersComposer::VIEW)
@endcan
