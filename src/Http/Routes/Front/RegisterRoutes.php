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
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        if ($this->isEnabled()) {
            $this->group($this->getRouteAttribute(), function () {
                $this->get('/', [
                    'as'   => 'get',     // auth::register.get
                    'uses' => 'RegisterController@showRegistrationForm',
                ]);

                $this->post('/', [
                    'as'   => 'post',    // auth::register.post
                    'uses' => 'RegisterController@register',
                ]);

                $this->get('confirm/{code}', [
                    'as'   => 'confirm', // auth::register.confirm
                    'uses' => 'RegisterController@confirm',
                ]);
            });
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function isEnabled()
    {
        return config('arcanesoft.auth.authentication.enabled.register', false);
    }

    protected function getRouteAttribute()
    {
        return array_merge([
            'prefix' => 'register',
            'as'     => 'register.',
        ], config('arcanesoft.auth.authentication.routes.register', []));
    }
}
