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
    }

    private function registerOtherComposers()
    {
        view()->composer(
            'auth::foundation.roles._partials.permissions-checkbox',
            'Arcanesoft\Auth\ViewComposers\PermissionsComposer@composeRolePermissions'
        );

        view()->composer(
            'auth::foundation.users.list',
            'Arcanesoft\Auth\ViewComposers\RolesComposer@composeFilters'
        );

        view()->composer(
            'auth::foundation.permissions.list',
            'Arcanesoft\Auth\ViewComposers\PermissionsGroupsComposer@composeFilters'
        );
    }
}
