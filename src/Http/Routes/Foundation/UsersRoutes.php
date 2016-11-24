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
        $this->bind('auth_user', function($hashedId) {
            return User::firstHashedOrFail($hashedId);
        });

        $this->group(['prefix' => 'users', 'as' => 'users.'], function () {
            $this->get('/', [
                'as'   => 'index',         // auth::foundation.users.index
                'uses' => 'UsersController@index',
            ]);

            $this->get('trash', [
                'as'   => 'trash',         // auth::foundation.users.trash
                'uses' => 'UsersController@trashList',
            ]);

            $this->get('roles-filter/{auth_role}', [
                'as'   => 'roles-filter.index',  // auth::foundation.users.roles-filter.index
                'uses' => 'UsersController@listByRole',
            ]);

            $this->get('create', [
                'as'   => 'create',        // auth::foundation.users.create
                'uses' => 'UsersController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',         // auth::foundation.users.store
                'uses' => 'UsersController@store',
            ]);

            $this->group(['prefix' => '{auth_user}'], function () {
                $this->get('/', [
                    'as'   => 'show',      // auth::foundation.users.show
                    'uses' => 'UsersController@show',
                ]);

                $this->get('edit', [
                    'as'   => 'edit',      // auth::foundation.users.edit
                    'uses' => 'UsersController@edit',
                ]);

                $this->put('update', [
                    'as'   => 'update',    // auth::foundation.users.update
                    'uses' => 'UsersController@update',
                ]);

                $this->put('activate', [
                    'as'   => 'activate',  // auth::foundation.users.activate
                    'uses' => 'UsersController@activate',
                ]);

                $this->put('restore', [
                    'as'   => 'restore',   // auth::foundation.users.restore
                    'uses' => 'UsersController@restore',
                ]);

                $this->delete('delete', [
                    'as'   => 'delete',    // auth::foundation.users.delete
                    'uses' => 'UsersController@delete',
                ]);

                $this->get('impersonate', [
                    'as'   => 'impersonate',      // auth::foundation.users.impersonate
                    'uses' => 'UsersController@impersonate',
                ]);
            });
        });
    }
}
