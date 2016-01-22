<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\AuthorizationServiceProvider as ServiceProvider;
use Arcanesoft\Auth\Policies;
use Arcanesoft\Contracts\Auth\Models\User;
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
        parent::registerPolicies($gate);

        $this->registerUsersPolicies($gate);
        $this->registerRolesPolicies($gate);
        $this->registerPermissionsPolicies($gate);
        $this->registerOtherPolicies($gate);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies
     | ------------------------------------------------------------------------------------------------
     */
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
     * Register other authorizations for auth module.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerOtherPolicies(GateContract $gate)
    {
        $gate->define('auth.dashboard.stats', function (User $user) {
            return $user->may('auth.dashboard.stats');
        });
    }
}
