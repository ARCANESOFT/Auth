<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     AuthenticateRoutes
 *
 * @package  App\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthenticateRoutes extends RouteRegister
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
        $this->group([
            'prefix' => 'login',
            'as'     => 'login.',
        ], function () {
            $this->get('/', [
                'as'   => 'get',  // auth::login.get
                'uses' => 'AuthController@getLogin',
            ]);

            $this->post('/', [
                'as'   => 'post', // auth::login.post
                'uses' => 'AuthController@postLogin',
            ]);
        });

        $this->get('logout', [
            'as'   => 'logout',   // auth::logout
            'uses' => 'AuthController@getLogout',
        ]);
    }
}
