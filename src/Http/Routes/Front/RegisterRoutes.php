<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Support\Arr;

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
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        $configs = config('arcanesoft.auth.authentication.register');

        if ( ! Arr::get($configs, 'enabled', false)) return;

        $this->group(Arr::get($configs, 'route.attributes', [
            'prefix' => 'register',
            'as'     => 'register.',
        ]), function () {
            $this->get('/', [
                'as'   => 'get',     // auth::register.get
                'uses' => 'AuthController@getRegister',
            ]);

            $this->post('/', [
                'as'   => 'post',    // auth::register.post
                'uses' => 'AuthController@postRegister',
            ]);

            $this->get('confirm/{code}', [
                'as'   => 'confirm', // auth::register.confirm
                'uses' => 'AuthController@getConfirm',
            ]);
        });
    }
}
