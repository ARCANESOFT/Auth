<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;

/**
 * Class     UsersRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersRoutes extends RouteRegistrar
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Register the bindings.
     */
    public static function bindings()
    {
        $registrar = new static;

        $registrar->bind('auth_user', function($hashedId) {
            return call_user_func([config('auth.providers.users.model'), 'firstHashedOrFail'], $hashedId);
        });
    }

    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('users')->name('users.')->group(function () {
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

            $this->prefix('{auth_user}')->group(function () {
                $this->get('/', 'UsersController@show')
                     ->name('show'); // admin::auth.users.show

                $this->get('edit', 'UsersController@edit')
                     ->name('edit'); // admin::auth.users.edit

                $this->put('update', 'UsersController@update')
                     ->name('update'); // admin::auth.users.update

                $this->put('activate', 'UsersController@activate')
                     ->middleware('ajax')
                     ->name('activate'); // admin::auth.users.activate

                $this->put('restore', 'UsersController@restore')
                     ->middleware('ajax')
                     ->name('restore'); // admin::auth.users.restore

                $this->delete('delete', 'UsersController@delete')
                     ->middleware('ajax')
                     ->name('delete'); // admin::auth.users.delete

                if (impersonator()->isEnabled()) {
                    $this->get('impersonate', 'UsersController@impersonate')
                         ->name('impersonate'); // admin::auth.users.impersonate
                }
            });
        });
    }
}
