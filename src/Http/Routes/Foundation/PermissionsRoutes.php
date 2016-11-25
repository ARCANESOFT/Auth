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
            $this->get('/', 'PermissionsController@index')
                 ->name('index'); // auth::foundation.permissions.index

            $this->get('group/{auth_permissions_group}', 'PermissionsController@group')
                 ->name('group'); // auth::foundation.permissions.group

            $this->group(['prefix' => '{auth_permission}'], function () {
                $this->get('/', 'PermissionsController@show')
                     ->name('show'); // auth::foundation.permissions.show

                $this->delete('roles/{auth_role}/detach', 'PermissionsController@detachRole')
                     ->name('roles.detach'); // auth::foundation.permissions.roles.detach
            });
        });
    }
}
