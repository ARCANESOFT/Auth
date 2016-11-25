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

    /**
     * Map the login routes.
     */
    protected function mapLoginRoutes()
    {
        $attributes = array_merge([
            'prefix' => 'login',
            'as'     => 'login.',
        ], config('arcanesoft.auth.authentication.routes.login', []));

        $this->group($attributes, function () {
            $this->get('/', 'LoginController@showLoginForm')
                 ->name('get'); // auth::login.get

            $this->post('/', 'LoginController@login')
                 ->name('post'); // auth::login.post
        });
    }

    /**
     * Map the logout routes
     */
    protected function mapLogoutRoute()
    {
        $attributes = array_merge([
            'prefix' => 'logout',
        ], config('arcanesoft.auth.authentication.routes.logout', []));

        $this->group($attributes, function () {
            $this->get('/', 'LoginController@logout')
                 ->name('logout'); // auth::logout
        });
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
        return config('arcanesoft.auth.authentication.enabled.login-logout', false);
    }
}
