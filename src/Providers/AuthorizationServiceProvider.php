<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;
use Arcanesoft\Auth\Policies;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;

/**
 * Class     AuthorizationServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthorizationServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    public function boot(GateContract $gate)
    {
        parent::registerPolicies();

        $this->registerDashboardPolicies($gate);
        $this->registerUsersPolicies($gate);
        $this->registerRolesPolicies($gate);
        $this->registerPermissionsPolicies($gate);
        $this->registerPasswordResetsPolicies($gate);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register dashboard authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerDashboardPolicies($gate)
    {
        $this->defineMany($gate,
            Policies\DashboardPolicy::class,
            Policies\DashboardPolicy::getPolicies()
        );
    }

    /**
     * Register users authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerUsersPolicies(GateContract $gate)
    {
        $this->defineMany($gate,
            Policies\UsersPolicy::class,
            Policies\UsersPolicy::getPolicies()
        );
    }

    /**
     * Register roles authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerRolesPolicies(GateContract $gate)
    {
        $this->defineMany($gate,
            Policies\RolesPolicy::class,
            Policies\RolesPolicy::getPolicies()
        );
    }

    /**
     * Register permissions authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerPermissionsPolicies(GateContract $gate)
    {
        $this->defineMany($gate,
            Policies\PermissionsPolicy::class,
            Policies\PermissionsPolicy::getPolicies()
        );
    }

    /**
     * Register password resets authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerPasswordResetsPolicies(GateContract $gate)
    {
        $this->defineMany($gate,
            Policies\PasswordResetsPolicy::class,
            Policies\PasswordResetsPolicy::getPolicies()
        );
    }
}
