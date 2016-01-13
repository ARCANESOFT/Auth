<?php namespace Arcanesoft\Auth\Providers;

use Arcanesoft\Contracts\Auth\Models\User;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        $gate->define('auth.users.list', function (User $user) {
            return $user->may('auth.users.list');
        });

        $gate->define('auth.users.show', function (User $user) {
            return $user->may('auth.users.show');
        });

        $gate->define('auth.users.create', function (User $user) {
            return $user->may('auth.users.create');
        });

        $gate->define('auth.users.update', function (User $user) {
            return $user->may('auth.users.update');
        });

        $gate->define('auth.users.delete', function (User $user) {
            return $user->may('auth.users.delete');
        });
    }

    /**
     * Register roles authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerRolesPolicies(GateContract $gate)
    {
        $gate->define('auth.roles.list', function (User $user) {
            return $user->may('auth.roles.list');
        });

        $gate->define('auth.roles.show', function (User $user) {
            return $user->may('auth.roles.show');
        });

        $gate->define('auth.roles.create', function (User $user) {
            return $user->may('auth.roles.create');
        });

        $gate->define('auth.roles.update', function (User $user) {
            return $user->may('auth.roles.update');
        });

        $gate->define('auth.roles.delete', function (User $user) {
            return $user->may('auth.roles.delete');
        });
    }

    /**
     * Register permissions authorizations.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     */
    private function registerPermissionsPolicies(GateContract $gate)
    {
        $gate->define('auth.permissions.list', function (User $user) {
            return $user->may('auth.permissions.list');
        });

        $gate->define('auth.permissions.show', function (User $user) {
            return $user->may('auth.permissions.show');
        });

        $gate->define('auth.permissions.update', function (User $user) {
            return $user->may('auth.permissions.update');
        });
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
