<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     SocialiteRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SocialiteRoutes extends RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar $router
     */
    public function map(Registrar $router)
    {
        $this->group([
            'prefix' => 'social/{social_provider}',
            'as'     => 'social.',
        ], function () {
            $this->get('/', 'SocialAuthController@redirectToProvider')
                ->name('redirect'); // auth::social.redirect

            $this->get('/', 'SocialAuthController@handleCallback')
                ->name('handle'); // auth::social.handle
        });
    }
}
