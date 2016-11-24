<?php namespace Arcanesoft\Auth\Http\Routes\Front;

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
        $this->group([
            'prefix' => 'users/impersonate',
            'as'     => 'users.impersonate.',
        ], function () {
            $this->get('stop', [
                'as'   => 'stop', // auth::users.impersonate.stop
                'uses' => 'ImpersonateController@stop',
            ]);
        });
    }
}
