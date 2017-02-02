<?php namespace Arcanesoft\Auth\Http\Routes\Admin;

use Arcanedev\Support\Routing\RouteRegistrar;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;

/**
 * Class     PermissionsRoutes
 *
 * @package  Arcanesoft\Auth\Http\Routes\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo Fixing the issue with nested groups and removing the `clear()` method.
 */
class PermissionsRoutes extends RouteRegistrar
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Map routes.
     */
    public function map()
    {
        $this->bind('auth_permission', function($hashedId) {
            return Permission::firstHashedOrFail($hashedId);
        });

        $this->bind('auth_permissions_group', function($hashedId) {
            return PermissionsGroup::firstHashedOrFail($hashedId);
        });

        $this->clear()->prefix('permissions')->name('permissions.')->group(function () {
            $this->get('/', 'PermissionsController@index')
                 ->name('index'); // admin::auth.permissions.index

            $this->get('group/{auth_permissions_group}', 'PermissionsController@group')
                 ->name('group'); // admin::auth.permissions.group

            $this->clear()->prefix('{auth_permission}')->group(function () {
                $this->get('/', 'PermissionsController@show')
                     ->name('show'); // admin::auth.permissions.show

                $this->delete('roles/{auth_role}/detach', 'PermissionsController@detachRole')
                     ->name('roles.detach'); // admin::auth.permissions.roles.detach
            });
        });
    }
}
