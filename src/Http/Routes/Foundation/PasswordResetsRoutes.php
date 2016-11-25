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
            $this->get('/', 'PasswordResetsController@index')
                 ->name('index');

            $this->delete('clear', 'PasswordResetsController@clear')
                 ->name('clear');

            $this->delete('delete', 'PasswordResetsController@delete')
                 ->name('delete');
        });
    }
}
