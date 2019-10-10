<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Routes;

use Arcanesoft\Auth\Http\Controllers\Datatables\PasswordResetsController as PasswordResetsDataTablesController;
use Arcanesoft\Auth\Http\Controllers\PasswordResetsController;

/**
 * Class     PasswordResetsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsRoutes extends RouteRegistrar
{
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
            $this->name('password-resets.')->prefix('password-resets')->group(function () {
                $this->get('/', [PasswordResetsController::class, 'index'])
                     ->name('index'); // admin::authorization.password-resets.index

                $this->dataTableGroup(function () {
                    $this->get('/', [PasswordResetsDataTablesController::class, 'index'])
                        ->name('index'); // admin::auth.password-resets.datatables.index
                });

                $this->get('metrics', [PasswordResetsController::class, 'metrics'])
                     ->name('metrics'); // admin::authorization.password-resets.metrics
            });
        });
    }
}
