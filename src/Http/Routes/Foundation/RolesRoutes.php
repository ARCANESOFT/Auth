<?php namespace Arcanesoft\Auth\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Auth\Models\Role;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     RolesRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Foundation
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
                 ->name('index'); // auth::foundation.roles.index

            $this->get('create', 'RolesController@create')
                 ->name('create'); // auth::foundation.roles.create

            $this->post('store', 'RolesController@store')
                 ->name('store'); // auth::foundation.roles.store

            $this->group(['prefix' => '{auth_role}'], function () {
                $this->get('/', 'RolesController@show')
                     ->name('show'); // auth::foundation.roles.show

                $this->get('edit', 'RolesController@edit')
                     ->name('edit'); // auth::foundation.roles.edit

                $this->put('update', 'RolesController@update')
                     ->name('update'); // auth::foundation.roles.update

                $this->put('activate', 'RolesController@activate')
                     ->name('activate'); // auth::foundation.roles.activate

                $this->delete('delete', 'RolesController@delete')
                     ->name('delete'); // auth::foundation.roles.delete
            });
        });
    }
}
