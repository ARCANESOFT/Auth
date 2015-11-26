<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     RegisterRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RegisterRoutes extends RouteRegister
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

        $this->group([
            'prefix' => 'register'
        ], function () {
            $this->get('/', [
                'as'    => 'register.get',
                'uses'  => 'AuthController@getRegister',
            ]);

            $this->post('/', [
                'as'    => 'register.post',
                'uses'  => 'AuthController@postRegister',
            ]);

            $this->get('confirm/{code}', [
                'as'    => 'register.confirm',
                'uses'  => 'AuthController@getConfirm',
            ]);
        });
    }
}
