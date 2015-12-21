<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\ServiceProvider;

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
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        view()->composer(
            'auth::foundation.dashboard',
            'Arcanesoft\Auth\ViewComposers\DashboardComposer@compose'
        );

        view()->composer(
            'auth::foundation.roles._partials.permissions-checkbox',
            'Arcanesoft\Auth\ViewComposers\PermissionsComposer@composeRolePermissions'
        );

        view()->composer(
            'auth::foundation.permissions.list',
            'Arcanesoft\Auth\ViewComposers\PermissionsGroupsComposer@composeFilters'
        );
    }
}
