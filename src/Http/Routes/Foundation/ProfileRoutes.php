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
        parent::map($router);

        $this->group([
            'prefix'    => 'profile',
            'as'        => 'profile.',
        ], function () {
            $this->get('/', [
                'as'   => 'index',           // auth::foundation.profile.index
                'uses' => 'ProfileController@index',
            ]);

            $this->group([
                'prefix' => '{user_id}/password',
                'as'     => 'password.',
            ], function () {
                $this->put('/', [
                    'as'   => 'update', // auth::foundation.profile.password.update
                    'uses' => 'ProfileController@updatePassword',
                ]);
            });
        });
    }
}
