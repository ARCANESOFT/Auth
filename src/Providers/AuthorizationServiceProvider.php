<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;
use Arcanesoft\Auth\Policies\DashboardPolicy;
use Arcanesoft\Auth\Policies\PasswordResetsPolicy;
use Arcanesoft\Auth\Policies\PermissionsPolicy;
use Arcanesoft\Auth\Policies\RolesPolicy;
use Arcanesoft\Auth\Policies\UsersPolicy;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register any application authentication / authorization services.
     */
    public function boot()
    {
        parent::registerPolicies();

        $this->defineMany(DashboardPolicy::class, DashboardPolicy::policies());

        $this->defineMany(UsersPolicy::class, UsersPolicy::policies());

        $this->defineMany(RolesPolicy::class, RolesPolicy::policies());

        $this->defineMany(PermissionsPolicy::class, PermissionsPolicy::policies());

        $this->defineMany(PasswordResetsPolicy::class, PasswordResetsPolicy::policies());
    }
}
