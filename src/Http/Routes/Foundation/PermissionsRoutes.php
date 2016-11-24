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
        $this->bind('auth_permission', function($hashedId) {
            return Permission::firstHashedOrFail($hashedId);
        });

        $this->bind('auth_permissions_group', function($hashedId) {
            return PermissionsGroup::firstHashedOrFail($hashedId);
        });

        $this->group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
            $this->get('/', [
                'as'   => 'index',         // auth::foundation.permissions.index
                'uses' => 'PermissionsController@index',
            ]);

            $this->get('group/{auth_permissions_group}', [
                'as'   => 'group',         // auth::foundation.permissions.group
                'uses' => 'PermissionsController@group',
            ]);

            $this->group(['prefix' => '{auth_permission}'], function () {
                $this->get('/', [
                    'as'   => 'show',      // auth::foundation.permissions.show
                    'uses' => 'PermissionsController@show',
                ]);

                $this->delete('roles/{auth_role}/detach', [
                    'as'   => 'roles.detach',  // auth::foundation.permissions.roles.detach
                    'uses' => 'PermissionsController@detachRole',
                ]);
            });
        });
    }
}
