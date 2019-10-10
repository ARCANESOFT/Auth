<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Providers;

use Arcanesoft\Foundation\Core\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

/**
 * Class     AuthServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Getters
     | -----------------------------------------------------------------
     */

    /**
     * Get policy's classes.
     *
     * @return iterable
     */
    public function policyClasses(): iterable
    {
        return $this->app->get('config')->get('arcanesoft.auth.policies', []);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::after(function ($user, $ability) {
            /** @var  \App\Models\User  $user */
            return $user->isSuperAdmin()
                || $user->isAdmin()
                || $user->may($ability);
        });

        parent::boot();
    }
}
