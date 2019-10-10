<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Routes\Roles;

use Arcanesoft\Auth\Http\Controllers\Roles\UsersController;
use Arcanesoft\Auth\Http\Routes\{RolesRoutes, RouteRegistrar};
use Arcanesoft\Auth\Repositories\RolesRepository;
use Illuminate\Routing\Route;

/**
 * Class     UsersRoutes
 *
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const USER_WILDCARD = 'admin_auth_role_user';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes.
     */
    public function map(): void
    {
        $this->prefix('users')->name('users.')->group(function () {
            $this->prefix('{'.self::USER_WILDCARD.'}')->group(function () {
                // admin::auth.roles.users.detach
                $this->delete('detach', [UsersController::class, 'detach'])
                     ->name('detach');
            });
        });
    }

    /**
     * Register the route bindings.
     */
    public function bindings(RolesRepository $repo): void
    {
        $this->bind(self::USER_WILDCARD, function (string $uuid, Route $route) use ($repo) {
            return $repo->firstUserWithUuidOrFail(
                $route->parameter(RolesRoutes::ROLE_WILDCARD),
                $uuid
            );
        });
    }
}