<?php namespace Arcanesoft\Auth\Http\Routes\Foundation;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PermissionsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsRoutes extends RouteRegister
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
        parent::map($router);

        $this->group([
            'prefix'    => 'permissions',
            'as'        => 'permissions.',
        ], function () {
            $this->get('/', [
                'as'   => 'index', // auth::foundation.permissions.index
                'uses' => 'PermissionsController@index',
            ]);

            $this->get('group/{perms_group_id}', [
                'as'   => 'group', // auth::foundation.permissions.group
                'uses' => 'PermissionsController@group',
            ]);

            $this->get('{permission_id}/show', [
                'as'   => 'show',  // auth::foundation.permissions.show
                'uses' => 'PermissionsController@show',
            ]);

            $this->delete('{permission_id}/roles/{role_id}/detach', [
                'as'   => 'roles.detach',  // auth::foundation.permissions.roles.detach
                'uses' => 'PermissionsController@detachRole',
            ]);
        });

        $router->bind('permission_id', function($hashedId) {
            return Permission::firstHashedOrFail($hashedId);
        });

        $router->bind('perms_group_id', function($hashedId) {
            if (head(hasher()->decode($hashedId)) === 0) {
                return null;
            }

            return PermissionsGroup::firstHashedOrFail($hashedId);
        });
    }
}
