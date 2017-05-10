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
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register any application authentication / authorization services.
     */
    public function boot()
    {
        parent::registerPolicies();

        $authPolicies = [
            DashboardPolicy::class      => DashboardPolicy::policies(),
            UsersPolicy::class          => UsersPolicy::policies(),
            RolesPolicy::class          => RolesPolicy::policies(),
            PermissionsPolicy::class    => PermissionsPolicy::policies(),
            PasswordResetsPolicy::class => PasswordResetsPolicy::policies()
        ];

        foreach ($authPolicies as $class => $policies) {
            $this->defineMany($class, $policies);
        }
    }
}
