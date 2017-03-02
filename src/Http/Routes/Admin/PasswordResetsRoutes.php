<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     PasswordResetsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('password-resets')->name('password-resets.')->group(function () {
            $this->get('/', 'PasswordResetsController@index')
                 ->name('index');  // admin::auth.password-resets.index

            $this->delete('clear', 'PasswordResetsController@clear')
                 ->name('clear');  // admin::auth.password-resets.clear

            $this->delete('delete', 'PasswordResetsController@delete')
                 ->name('delete'); // admin::auth.password-resets.delete
        });
    }
}
