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
            $this->get('/', 'UsersController@index')
                 ->name('index'); // auth::foundation.users.index

            $this->get('trash', 'UsersController@trashList')
                 ->name('trash'); // auth::foundation.users.trash

            $this->get('roles-filter/{auth_role}', 'UsersController@listByRole')
                 ->name('roles-filter.index'); // auth::foundation.users.roles-filter.index

            $this->get('create', 'UsersController@create')
                 ->name('create'); // auth::foundation.users.create

            $this->post('store', 'UsersController@store')
                 ->name('store'); // auth::foundation.users.store

            $this->group(['prefix' => '{auth_user}'], function () {
                $this->get('/', 'UsersController@show')
                     ->name('show'); // auth::foundation.users.show

                $this->get('edit', 'UsersController@edit')
                     ->name('edit'); // auth::foundation.users.edit

                $this->put('update', 'UsersController@update')
                     ->name('update'); // auth::foundation.users.update

                $this->put('activate', 'UsersController@activate')
                     ->name('activate'); // auth::foundation.users.activate

                $this->put('restore', 'UsersController@restore')
                     ->name('restore'); // auth::foundation.users.restore

                $this->delete('delete', 'UsersController@delete')
                     ->name('delete'); // auth::foundation.users.delete

                $this->get('impersonate', 'UsersController@impersonate')
                     ->name('impersonate'); // auth::foundation.users.impersonate
            });
        });
    }
}
