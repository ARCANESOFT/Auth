<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     AuthenticationRoutes
 *
 * @package  App\Http\Routes
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthenticationRoutes extends RouteRegister
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
            $this->mapLoginRoutes();
            $this->mapLogoutRoute();
        }
    }

    protected function mapLoginRoutes()
    {
        $attributes = array_merge([
            'prefix' => 'login',
            'as'     => 'login.',
        ], config('arcanesoft.auth.authentication.routes.login', []));

        $this->group($attributes, function () {
            $this->get('/',  [
                'as'   => 'get',  // auth::login.get
                'uses' => 'LoginController@showLoginForm',
            ]);

            $this->post('/', [
                'as'   => 'post', // auth::login.post
                'uses' => 'LoginController@login',
            ]);
        });
    }

    protected function mapLogoutRoute()
    {
        $attributes = array_merge([
            'prefix' => 'logout',
        ], config('arcanesoft.auth.authentication.routes.logout', []));

        $this->group($attributes, function () {
            $this->get('/', [
                'as'   => 'logout', // auth::logout
                'uses' => 'LoginController@logout',
            ]);
        });
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    protected function isEnabled()
    {
        return config('arcanesoft.auth.authentication.enabled.login-logout', false);
    }
}
