<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\LaravelAuth\Services\UserImpersonator;
use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Auth\Models\User;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     UsersRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
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
                 ->name('index'); // admin::auth.users.index

            $this->get('trash', 'UsersController@trashList')
                 ->name('trash'); // admin::auth.users.trash

            $this->get('roles-filter/{auth_role}', 'UsersController@listByRole')
                 ->name('roles-filter.index'); // admin::auth.users.roles-filter.index

            $this->get('create', 'UsersController@create')
                 ->name('create'); // admin::auth.users.create

            $this->post('store', 'UsersController@store')
                 ->name('store'); // admin::auth.users.store

            $this->group(['prefix' => '{auth_user}'], function () {
                $this->get('/', 'UsersController@show')
                     ->name('show'); // admin::auth.users.show

                $this->get('edit', 'UsersController@edit')
                     ->name('edit'); // admin::auth.users.edit

                $this->put('update', 'UsersController@update')
                     ->name('update'); // admin::auth.users.update

                $this->put('activate', 'UsersController@activate')
                     ->name('activate'); // admin::auth.users.activate

                $this->put('restore', 'UsersController@restore')
                     ->name('restore'); // admin::auth.users.restore

                $this->delete('delete', 'UsersController@delete')
                     ->name('delete'); // admin::auth.users.delete

                if (UserImpersonator::isEnabled()) {
                    $this->get('impersonate', 'UsersController@impersonate')
                         ->name('impersonate'); // admin::auth.users.impersonate
                }
            });
        });
    }
}
