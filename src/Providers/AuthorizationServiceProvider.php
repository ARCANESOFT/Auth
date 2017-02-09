<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;
use Arcanesoft\Auth\Policies;

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

        $this->registerDashboardPolicies();
        $this->registerUsersPolicies();
        $this->registerRolesPolicies();
        $this->registerPermissionsPolicies();
        $this->registerPasswordResetsPolicies();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register dashboard authorizations.
     */
    private function registerDashboardPolicies()
    {
        $this->defineMany(
            Policies\DashboardPolicy::class,
            Policies\DashboardPolicy::getPolicies()
        );
    }

    /**
     * Register users authorizations.
     */
    private function registerUsersPolicies()
    {
        $this->defineMany(
            Policies\UsersPolicy::class,
            Policies\UsersPolicy::getPolicies()
        );
    }

    /**
     * Register roles authorizations.
     */
    private function registerRolesPolicies()
    {
        $this->defineMany(
            Policies\RolesPolicy::class,
            Policies\RolesPolicy::getPolicies()
        );
    }

    /**
     * Register permissions authorizations.
     */
    private function registerPermissionsPolicies()
    {
        $this->defineMany(
            Policies\PermissionsPolicy::class,
            Policies\PermissionsPolicy::getPolicies()
        );
    }

    /**
     * Register password resets authorizations.
     */
    private function registerPasswordResetsPolicies()
    {
        $this->defineMany(
            Policies\PasswordResetsPolicy::class,
            Policies\PasswordResetsPolicy::getPolicies()
        );
    }
}
