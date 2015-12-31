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
     * {@inheritdoc}
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
            'auth::foundation.users.list',
            'Arcanesoft\Auth\ViewComposers\RolesComposer@composeFilters'
        );

        view()->composer(
            'auth::foundation.permissions.list',
            'Arcanesoft\Auth\ViewComposers\PermissionsGroupsComposer@composeFilters'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function register()
    {
        //
    }
}
