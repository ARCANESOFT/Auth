<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Routes;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Http\Controllers\Datatables\UsersController as UsersDatatablesController;
use Arcanesoft\Auth\Http\Controllers\UsersController;
use Arcanesoft\Auth\Repositories\UsersRepository;
use Illuminate\Http\Request;

/**
 * Class     UsersRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const USER_WILDCARD = 'admin_auth_user';

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
            $this->name('users.')->prefix('users')->group(function () {
                $this->get('/', [UsersController::class, 'index'])
                     ->name('index'); // admin::auth.users.index

                $this->get('trash', [UsersController::class, 'trash'])
                     ->name('trash'); // admin::auth.users.trash

                $this->mapDataTablesRoutes();

                $this->get('metrics', [UsersController::class, 'metrics'])
                     ->name('metrics'); // admin::auth.users.metrics

                $this->get('create', [UsersController::class, 'create'])
                     ->name('create'); // admin::auth.users.create

                $this->post('store', [UsersController::class, 'store'])
                     ->name('store'); // admin::auth.users.post

                $this->prefix('{'.static::USER_WILDCARD.'}')->group(function () {
                    $this->get('/', [UsersController::class, 'show'])
                         ->name('show'); // admin::auth.users.show

                    $this->get('edit', [UsersController::class, 'edit'])
                         ->name('edit'); // admin::auth.users.edit

                    $this->put('update', [UsersController::class, 'update'])
                         ->name('update'); // admin::auth.users.update

                    $this->put('activate', [UsersController::class, 'activate'])
                         ->middleware(['ajax'])
                         ->name('activate'); // admin::auth.users.activate

                    $this->delete('delete', [UsersController::class, 'delete'])
                         ->middleware(['ajax'])
                         ->name('delete'); // admin::auth.users.delete

                    $this->put('restore', [UsersController::class, 'restore'])
                         ->middleware(['ajax'])
                         ->name('restore'); // admin::auth.users.restore

                    if (impersonator()->isEnabled()) {
                        $this->get('impersonate', [UsersController::class, 'impersonate'])
                             ->name('impersonate'); // admin::auth.users.impersonate
                    }
                });
            });
        });
    }

    /**
     * Map the datatables routes.
     */
    protected function mapDataTablesRoutes(): void
    {
        $this->dataTableGroup(function () {
            $this->get('/', [UsersDataTablesController::class, 'index'])
                 ->name('index'); // admin::auth.users.datatables.index

            $this->get('trash', [UsersDataTablesController::class, 'trash'])
                 ->name('trash'); // admin::auth.users.datatables.trash
        });
    }

    /**
     * Register the route bindings.
     */
    public function bindings(UsersRepository $repo, Request $request): void
    {
        $this->bind(static::USER_WILDCARD, function (string $uuid) use ($repo, $request) {
            return $repo->firstWhereUuidOrFail($uuid);
        });
    }
}
