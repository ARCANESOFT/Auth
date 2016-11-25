<?php namespace Arcanesoft\Auth\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     ProfileRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ProfileRoutes extends RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        $this->group(['prefix' => 'profile', 'as' => 'profile.'], function () {
            $this->get('/', 'ProfileController@index')
                 ->name('index'); // auth::foundation.profile.index

            // TODO: Remove the user id ??
            $this->group(['prefix' => '{auth_user}/password', 'as' => 'password.'], function () {
                $this->put('/', 'ProfileController@updatePassword')
                     ->name('update'); // auth::foundation.profile.password.update
            });
        });
    }
}
