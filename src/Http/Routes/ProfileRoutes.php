<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Routes;

use Arcanesoft\Auth\Http\Controllers\ProfileController;

/**
 * Class     ProfileRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ProfileRoutes extends RouteRegistrar
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
            $this->prefix('profile')->name('profile.')->middleware(['password.confirm'])->group(function () {
                $this->get('/', [ProfileController::class, 'index'])
                     ->name('index'); // admin::foundation.profile.index

                // Account
                $this->prefix('account')->name('account.')->group(function () {
                    $this->put('update', [ProfileController::class, 'updateAccount'])
                         ->name('update'); // admin::foundation.profile.account.update
                });

                // Password
                $this->prefix('password')->name('password.')->group(function () {
                    $this->put('update', [ProfileController::class, 'updatePassword'])
                         ->name('update'); // admin::foundation.profile.password.update
                });
            });
        });
    }
}
