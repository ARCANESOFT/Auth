<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     StatsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class StatsRoutes extends RouteRegister
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
        $this->group(['prefix' => 'stats'], function () {
            $this->get('/', 'DashboardController@index')
                 ->name('dashboard'); // admin::auth.dashboard
        });
    }
}
