<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PasswordResetRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetRoutes extends RouteRegister
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
                $this->get('reset', 'ForgotPasswordController@showLinkRequestForm')
                     ->name('get'); // auth::password.get

                $this->post('email', 'ForgotPasswordController@sendResetLinkEmail')
                     ->name('email'); // auth::password.email

                $this->get('reset/{token}', 'ResetPasswordController@showResetForm')
                     ->name('token'); // auth::password.token

                $this->post('reset', 'ResetPasswordController@reset')
                     ->name('post'); // auth::password.post
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
        return config('arcanesoft.auth.authentication.enabled.password', false);
    }

    /**
     * Get the route attributes.
     *
     * @return array
     */
    protected function getRouteAttributes()
    {
        return array_merge([
            'prefix' => 'password',
            'as'     => 'password.',
        ], config('arcanesoft.auth.authentication.routes.password', []));
    }
}
