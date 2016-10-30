<?php namespace Arcanesoft\Auth\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PasswordResetsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsRoutes extends RouteRegister
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
        $this->group(['prefix' => 'password-resets', 'as' => 'password-resets.'], function () {
            $this->get('/', [
                'as'   => 'index',
                'uses' => 'PasswordResetsController@index',
            ]);

            $this->delete('clear', [
                'as'   => 'clear',
                'uses' => 'PasswordResetsController@clear',
            ]);

            $this->delete('delete', [
                'as'   => 'delete',
                'uses' => 'PasswordResetsController@delete',
            ]);
        });
    }
}
