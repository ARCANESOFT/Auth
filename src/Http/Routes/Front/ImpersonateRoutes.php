<?php namespace Arcanesoft\Auth\Http\Routes\Front;

use Arcanedev\LaravelAuth\Services\UserImpersonator;
use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     ImpersonateRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Front
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ImpersonateRoutes extends RouteRegister
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
        if (UserImpersonator::isEnabled()) {
            $this->group([
                'prefix' => 'users/impersonate',
                'as'     => 'users.impersonate.',
            ], function () {
                $this->get('stop', 'ImpersonateController@stop')
                    ->name('stop'); // auth::users.impersonate.stop
            });
        }
    }
}
