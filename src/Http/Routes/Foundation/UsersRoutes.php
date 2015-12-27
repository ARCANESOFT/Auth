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
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Registrar $router)
    {
        parent::map($router);

        $this->group([
            'prefix'    => 'users',
            'as'        => 'users.',
        ], function () {
            $this->get('/', [
                'as'   => 'index',  // auth::foundation.users.index
                'uses' => 'UsersController@index',
            ]);

            $this->get('trash', [
                'as'   => 'trash',  // auth::foundation.users.trash
                'uses' => 'UsersController@trashList',
            ]);

            $this->get('create', [
                'as'   => 'create', // auth::foundation.users.create
                'uses' => 'UsersController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',  // auth::foundation.users.store
                'uses' => 'UsersController@store',
            ]);

            $this->get('{user_id}/show', [
                'as'   => 'show',   // auth::foundation.users.show
                'uses' => 'UsersController@show',
            ]);

            $this->get('{user_id}/edit', [
                'as'   => 'edit',   // auth::foundation.users.edit
                'uses' => 'UsersController@edit',
            ]);

            $this->put('{user_id}/update', [
                'as'   => 'update', // auth::foundation.users.update
                'uses' => 'UsersController@update',
            ]);

            $this->put('{user_id}/activate', [
                'as'   => 'activate', // auth::foundation.users.activate
                'uses' => 'UsersController@activate',
            ]);

            $this->put('{user_id}/restore', [
                'as'   => 'restore', // auth::foundation.users.restore
                'uses' => 'UsersController@restore',
            ]);

            $this->delete('{user_id}/delete', [
                'as'   => 'delete', // auth::foundation.users.delete
                'uses' => 'UsersController@delete',
            ]);
        });

        $router->bind('user_id', function($hashedId) {
            return User::firstHashedOrFail($hashedId);
        });
    }
}
