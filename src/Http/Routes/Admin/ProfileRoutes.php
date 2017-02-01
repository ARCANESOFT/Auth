<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     ProfileRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ProfileRoutes extends RouteRegistrar
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('profile')->name('profile.')->group(function () {
            $this->get('/', 'ProfileController@index')
                 ->name('index'); // admin::auth.profile.index

            // TODO: Remove the user id ??
            $this->prefix('{auth_user}/password')->name('password.')->group(function () {
                $this->put('/', 'ProfileController@updatePassword')
                     ->name('update'); // admin::auth.profile.password.update
            });
        });
    }
}
