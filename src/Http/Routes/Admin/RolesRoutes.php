<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Auth\Models\Role;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     RolesRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesRoutes extends RouteRegister
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
        $this->bind('auth_role', function($hashedId) {
            return Role::firstHashedOrFail($hashedId);
        });

        $this->group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            $this->get('/', 'RolesController@index')
                 ->name('index'); // admin::auth.roles.index

            $this->get('create', 'RolesController@create')
                 ->name('create'); // admin::auth.roles.create

            $this->post('store', 'RolesController@store')
                 ->name('store'); // admin::auth.roles.store

            $this->group(['prefix' => '{auth_role}'], function () {
                $this->get('/', 'RolesController@show')
                     ->name('show'); // admin::auth.roles.show

                $this->get('edit', 'RolesController@edit')
                     ->name('edit'); // admin::auth.roles.edit

                $this->put('update', 'RolesController@update')
                     ->name('update'); // admin::auth.roles.update

                $this->put('activate', 'RolesController@activate')
                     ->name('activate'); // admin::auth.roles.activate

                $this->delete('delete', 'RolesController@delete')
                     ->name('delete'); // admin::auth.roles.delete
            });
        });
    }
}
