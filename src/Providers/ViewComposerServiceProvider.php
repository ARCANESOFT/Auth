<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\ViewComposerServiceProvider as ServiceProvider;
use Arcanesoft\Auth\ViewComposers;
use Arcanesoft\Auth\ViewComposers\Dashboard;

/**
 * Class     ViewComposerServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ViewComposerServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */
    /**
     * Register the composer classes.
     *
     * @var array
     */
    protected $composerClasses = [
        // Dashboard view composers
        Dashboard\UsersCountComposer::VIEW                   => Dashboard\UsersCountComposer::class,
        Dashboard\RolesCountComposer::VIEW                   => Dashboard\RolesCountComposer::class,
        Dashboard\PermissionsCountComposer::VIEW             => Dashboard\PermissionsCountComposer::class,
        Dashboard\LatestThirtyDaysCreatedUsersComposer::VIEW => Dashboard\LatestThirtyDaysCreatedUsersComposer::class,
        Dashboard\OnlineUsersCountComposer::VIEW             => Dashboard\OnlineUsersCountComposer::class,
    ];

    /* -----------------------------------------------------------------
     |  Main Functions
     | -----------------------------------------------------------------
     */
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        parent::boot();

        $this->registerOtherComposers();
    }

    /* -----------------------------------------------------------------
     |  Other Functions
     | -----------------------------------------------------------------
     */
    /**
     * Register other view composers.
     */
    private function registerOtherComposers()
    {
        $this->composer(
            'auth::admin.roles._partials.permissions-checkbox',
            'Arcanesoft\Auth\ViewComposers\PermissionsComposer@composeRolePermissions'
        );

        $this->composer(
            'auth::admin.users.list',
            'Arcanesoft\Auth\ViewComposers\RolesComposer@composeFilters'
        );

        $this->composer(
            ViewComposers\PermissionGroupsFilterComposer::VIEW,
            ViewComposers\PermissionGroupsFilterComposer::class
        );
    }
}
