<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\ServiceProvider;
use \Arcanesoft\Auth\ViewComposers\Dashboard;

/**
 * Class     ComposerServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ComposerServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->registerDashboardComposers();
        $this->registerOtherComposers();
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register all the dashboard view composers.
     */
    private function registerDashboardComposers()
    {
        view()->composer(
            Dashboard\UsersCountComposer::VIEW,
            Dashboard\UsersCountComposer::class
        );

        view()->composer(
            Dashboard\RolesCountComposer::VIEW,
            Dashboard\RolesCountComposer::class
        );

        view()->composer(
            Dashboard\PermissionsCountComposer::VIEW,
            Dashboard\PermissionsCountComposer::class
        );

        view()->composer(
            Dashboard\LatestThirtyDaysCreatedUsersComposer::VIEW,
            Dashboard\LatestThirtyDaysCreatedUsersComposer::class
        );

        view()->composer(
            Dashboard\OnlineUsersCountComposer::VIEW,
            Dashboard\OnlineUsersCountComposer::class
        );
    }

    private function registerOtherComposers()
    {
        view()->composer(
            'auth::admin.roles._partials.permissions-checkbox',
            'Arcanesoft\Auth\ViewComposers\PermissionsComposer@composeRolePermissions'
        );

        view()->composer(
            'auth::admin.users.list',
            'Arcanesoft\Auth\ViewComposers\RolesComposer@composeFilters'
        );

        view()->composer(
            \Arcanesoft\Auth\ViewComposers\PermissionGroupsFilterComposer::VIEW,
            \Arcanesoft\Auth\ViewComposers\PermissionGroupsFilterComposer::class
        );
    }
}
