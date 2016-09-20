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
                $this->get('reset', [
                    'as'   => 'get',   // auth::password.get
                    'uses' => 'ForgotPasswordController@showLinkRequestForm'
                ]);

                $this->post('email', [
                    'as'   => 'email', // auth::password.email
                    'uses' => 'ForgotPasswordController@sendResetLinkEmail'
                ]);

                $this->get('reset/{token}', [
                    'as'   => 'token', // auth::password.token
                    'uses' => 'ResetPasswordController@showResetForm'
                ]);

                $this->post('reset', [
                    'as'   => 'post',  // auth::password.post
                    'uses' => 'ResetPasswordController@reset'
                ]);
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
