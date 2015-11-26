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
     * @param  Registrar  $router
     */
    public function map(Registrar $router)
    {
        parent::map($router);

        $this->get('login', [
            'as'    => 'login.get',
            'uses'  => 'AuthController@getLogin'
        ]);

        $this->post('login', [
            'as'    => 'login.post',
            'uses'  => 'AuthController@postLogin'
        ]);

        $this->get('logout', [
            'as'    => 'logout',
            'uses'  => 'AuthController@getLogout',
        ]);
    }
}
