<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Routes\Roles;

use Arcanesoft\Auth\Http\Controllers\Roles\PermissionsController;
use Arcanesoft\Auth\Http\Routes\{RolesRoutes, RouteRegistrar};
use Arcanesoft\Auth\Repositories\RolesRepository;
use Illuminate\Routing\Route;

/**
 * Class     PermissionsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const PERMISSION_WILDCARD = 'admin_auth_role_permission';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes.
     */
    public function map(): void
    {
        $this->prefix('permissions')->name('permissions.')->group(function () {
            $this->prefix('{'.self::PERMISSION_WILDCARD.'}')->group(function () {
                // admin::auth.roles.permissions.detach
                $this->delete('detach', [PermissionsController::class, 'detach'])
                    ->name('detach');
            });
        });
    }

    /**
     * Register the route bindings.
     */
    public function bindings(RolesRepository $repo): void
    {
        $this->bind(self::PERMISSION_WILDCARD, function (string $uuid, Route $route) use ($repo) {
            return $repo->firstPermissionWithUuidOrFail(
                $route->parameter(RolesRoutes::ROLE_WILDCARD),
                $uuid
            );
        });
    }
}