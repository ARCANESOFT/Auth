<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Routes\Permissions;

use Arcanesoft\Auth\Http\Controllers\Permissions\RolesController;
use Arcanesoft\Auth\Http\Routes\PermissionsRoutes;
use Arcanesoft\Auth\Http\Routes\RouteRegistrar;
use Arcanesoft\Auth\Repositories\PermissionsRepository;
use Illuminate\Routing\Route;

/**
 * Class     RolesRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Permissions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const ROLE_WILDCARD = 'admin_auth_permission_role';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes.
     */
    public function map(): void
    {
        $this->prefix('roles')->name('roles.')->group(function () {
            $this->prefix('{'.self::ROLE_WILDCARD.'}')->group(function () {
                // admin::auth.permissions.roles.detach
                $this->delete('detach', [RolesController::class, 'detach'])
                     ->name('detach');
            });
        });
    }

    /**
     * Register the route bindings.
     */
    public function bindings(PermissionsRepository $repo): void
    {
        $this->bind(self::ROLE_WILDCARD, function (string $uuid, Route $route) use ($repo) {
            return $repo->firstRoleWhereUuidOrFail(
                $route->parameter(PermissionsRoutes::PERMISSION_WILDCARD),
                $uuid
            );
        });
    }
}