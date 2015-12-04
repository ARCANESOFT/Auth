<?php namespace Arcanesoft\Auth\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Auth\Models\User;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     UsersRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersRoutes extends RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     *
     * @param  Registrar  $router
     */
    public function map(Registrar $router)
    {
        parent::map($router);

        $this->group([
            'prefix'    => 'users',
            'as'        => 'users.',
        ], function () {
            $this->get('/', [
                'as'   => 'index',
                'uses' => 'UsersController@index',
            ]);

            $this->get('create', [
                'as'   => 'create',
                'uses' => 'UsersController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',
                'uses' => 'UsersController@store',
            ]);

            $this->get('{user_id}/show', [
                'as'   => 'show',
                'uses' => 'UsersController@show',
            ]);

            $this->get('{user_id}/edit', [
                'as'   => 'edit',
                'uses' => 'UsersController@edit',
            ]);

            $this->put('{user_id}/update', [
                'as'   => 'update',
                'uses' => 'UsersController@update',
            ]);

            $this->delete('{user_id}/delete', [
                'as'   => 'delete',
                'uses' => 'UsersController@delete',
            ]);
        });

        $router->bind('user_id', function($hashedId) {
            return User::firstHashedOrFail($hashedId);
        });
    }
}
