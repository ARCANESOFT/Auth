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
            $this->group($this->getRouteAttributes(), function () {
                $this->get('/', 'RegisterController@showRegistrationForm')
                     ->name('get'); // auth::register.get

                $this->post('/', 'RegisterController@register')
                     ->name('post'); // auth::register.post

                $this->get('confirm/{code}', 'RegisterController@confirm')
                     ->name('confirm'); // auth::register.confirm
            });
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if enabled.
     *
     * @return bool
     */
    protected function isEnabled()
    {
        return config('arcanesoft.auth.authentication.enabled.register', false);
    }

    /**
     * Get the route attributes.
     *
     * @return array
     */
    protected function getRouteAttributes()
    {
        return array_merge([
            'prefix' => 'register',
            'as'     => 'register.',
        ], config('arcanesoft.auth.authentication.routes.register', []));
    }
}
