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
            $this->get('/', [
                'as'   => 'index',         // auth::foundation.roles.index
                'uses' => 'RolesController@index',
            ]);

            $this->get('create', [
                'as'   => 'create',        // auth::foundation.roles.create
                'uses' => 'RolesController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',         // auth::foundation.roles.store
                'uses' => 'RolesController@store',
            ]);

            $this->group(['prefix' => '{auth_role}'], function () {
                $this->get('show', [
                    'as'   => 'show',      // auth::foundation.roles.show
                    'uses' => 'RolesController@show',
                ]);

                $this->get('edit', [
                    'as'   => 'edit',      // auth::foundation.roles.edit
                    'uses' => 'RolesController@edit',
                ]);

                $this->put('update', [
                    'as'   => 'update',    // auth::foundation.roles.update
                    'uses' => 'RolesController@update',
                ]);

                $this->put('activate', [
                    'as'   => 'activate',  // auth::foundation.roles.activate
                    'uses' => 'RolesController@activate',
                ]);

                $this->delete('delete', [
                    'as'   => 'delete',    // auth::foundation.roles.delete
                    'uses' => 'RolesController@delete',
                ]);
            });
        });
    }
}
