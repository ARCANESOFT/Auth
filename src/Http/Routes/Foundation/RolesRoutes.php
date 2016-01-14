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
        $this->group([
            'prefix'    => 'roles',
            'as'        => 'roles.',
        ], function () {
            $this->get('/', [
                'as'   => 'index',    // auth::foundation.roles.index
                'uses' => 'RolesController@index',
            ]);

            $this->get('create', [
                'as'   => 'create',   // auth::foundation.roles.create
                'uses' => 'RolesController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',    // auth::foundation.roles.store
                'uses' => 'RolesController@store',
            ]);

            $this->get('{role_id}/show', [
                'as'   => 'show',     // auth::foundation.roles.show
                'uses' => 'RolesController@show',
            ]);

            $this->get('{role_id}/edit', [
                'as'   => 'edit',     // auth::foundation.roles.edit
                'uses' => 'RolesController@edit',
            ]);

            $this->put('{role_id}/update', [
                'as'   => 'update',   // auth::foundation.roles.update
                'uses' => 'RolesController@update',
            ]);

            $this->put('{role_id}/activate', [
                'as'   => 'activate', // auth::foundation.roles.activate
                'uses' => 'RolesController@activate',
            ]);

            $this->delete('{role_id}/delete', [
                'as'   => 'delete',   // auth::foundation.roles.delete
                'uses' => 'RolesController@delete',
            ]);
        });

        $router->bind('role_id', function($hashedId) {
            return Role::firstHashedOrFail($hashedId);
        });
    }
}
