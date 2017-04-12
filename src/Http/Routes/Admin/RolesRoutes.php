<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;
use Arcanesoft\Auth\Models\Role;

/**
 * Class     RolesRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesRoutes extends RouteRegistrar
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

        $registrar->bind('auth_role', function($hashedId) {
            return Role::firstHashedOrFail($hashedId);
        });
    }

    /**
     * Map routes.
     */
    public function map()
    {
        $this->prefix('roles')->name('roles.')->group(function () {
            $this->get('/', 'RolesController@index')
                 ->name('index'); // admin::auth.roles.index

            $this->get('create', 'RolesController@create')
                 ->name('create'); // admin::auth.roles.create

            $this->post('store', 'RolesController@store')
                 ->name('store'); // admin::auth.roles.store

            $this->prefix('{auth_role}')->group(function () {
                $this->get('/', 'RolesController@show')
                     ->name('show'); // admin::auth.roles.show

                $this->get('edit', 'RolesController@edit')
                     ->name('edit'); // admin::auth.roles.edit

                $this->put('update', 'RolesController@update')
                     ->name('update'); // admin::auth.roles.update

                $this->put('activate', 'RolesController@activate')
                     ->middleware('ajax')
                     ->name('activate'); // admin::auth.roles.activate

                $this->delete('delete', 'RolesController@delete')
                     ->middleware('ajax')
                     ->name('delete'); // admin::auth.roles.delete
            });
        });
    }
}
