<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Routes;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Http\Controllers\Datatables\RolesController as RolesDataTablesController;
use Arcanesoft\Auth\Http\Controllers\RolesController;
use Arcanesoft\Auth\Repositories\RolesRepository;

/**
 * Class     RolesRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const ROLE_WILDCARD = 'admin_auth_role';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Map the routes.
     */
    public function map(): void
    {
        $this->adminGroup(function () {
            $this->name('roles.')->prefix('roles')->group(function () {
                $this->get('/', [RolesController::class, 'index'])
                     ->name('index'); // admin::auth.roles.index

                $this->mapDataTablesRoutes();

                $this->get('metrics', [RolesController::class, 'metrics'])
                     ->name('metrics'); // admin::auth.roles.metrics

                $this->get('create', [RolesController::class, 'create'])
                     ->name('create'); // admin::auth.roles.create

                $this->post('store', [RolesController::class, 'store'])
                     ->name('store'); // admin::auth.roles.store

                $this->prefix('{'.self::ROLE_WILDCARD.'}')->group(function () {
                    $this->get('/', [RolesController::class, 'show'])
                         ->name('show'); // admin::auth.roles.show

                    $this->get('edit', [RolesController::class, 'edit'])
                         ->name('edit'); // admin::auth.roles.edit

                    $this->put('update', [RolesController::class, 'update'])
                         ->name('update'); // admin::auth.roles.update

                    $this->put('activate', [RolesController::class, 'activate'])
                         ->middleware(['ajax'])
                         ->name('activate'); // admin::auth.roles.activate

                    $this->delete('delete', [RolesController::class, 'delete'])
                         ->middleware(['ajax'])
                         ->name('delete'); // admin::auth.roles.delete

                    $this->namespace('Roles')->group(function () {
                        static::mapRouteClasses([
                            Roles\PermissionsRoutes::class,
                            Roles\UsersRoutes::class,
                        ]);
                    });
                });
            });
        });
    }

    /**
     * Map datatables routes.
     */
    protected function mapDataTablesRoutes(): void
    {
        $this->dataTableGroup(function () {
            $this->get('/', [RolesDataTablesController::class, 'index'])
                 ->name('index'); // admin::auth.roles.datatables.index
        });
    }

    /**
     * Register the route bindings.
     */
    public function bindings(RolesRepository $repo): void
    {
        $this->bind(self::ROLE_WILDCARD, function (string $uuid) use ($repo) {
            return $repo->firstWithUuidOrFail($uuid);
        });

        static::bindRouteClasses([
            Roles\PermissionsRoutes::class,
            Roles\UsersRoutes::class,
        ]);
    }
}
