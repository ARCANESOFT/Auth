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
     * @param  Registrar  $router
     */
    public function map(Registrar $router)
    {
        parent::map($router);

        $this->group([
            'prefix'    => 'roles',
            'as'        => 'roles.',
        ], function () {
            $this->get('/', [
                'as'   => 'index',
                'uses' => 'RolesController@index',
            ]);

            $this->get('create', [
                'as'   => 'create',
                'uses' => 'RolesController@create',
            ]);

            $this->post('store', [
                'as'   => 'store',
                'uses' => 'RolesController@store',
            ]);

            $this->get('{role_id}/show', [
                'as'   => 'show',
                'uses' => 'RolesController@show',
            ]);

            $this->get('{role_id}/edit', [
                'as'   => 'edit',
                'uses' => 'RolesController@edit',
            ]);

            $this->put('{role_id}/update', [
                'as'   => 'update',
                'uses' => 'RolesController@update',
            ]);

            $this->delete('{role_id}/delete', [
                'as'   => 'delete',
                'uses' => 'RolesController@delete',
            ]);
        });

        $router->bind('role_id', function($hashedId) {
            return Role::firstHashedOrFail($hashedId);
        });
    }
}
