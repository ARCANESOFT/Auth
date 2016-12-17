<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Bases\RouteRegister;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     PermissionsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
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
                 ->name('index'); // admin::auth.permissions.index

            $this->get('group/{auth_permissions_group}', 'PermissionsController@group')
                 ->name('group'); // admin::auth.permissions.group

            $this->group(['prefix' => '{auth_permission}'], function () {
                $this->get('/', 'PermissionsController@show')
                     ->name('show'); // admin::auth.permissions.show

                $this->delete('roles/{auth_role}/detach', 'PermissionsController@detachRole')
                     ->name('roles.detach'); // admin::auth.permissions.roles.detach
            });
        });
    }
}
