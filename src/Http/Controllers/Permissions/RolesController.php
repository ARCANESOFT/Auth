<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers\Permissions;

use Arcanesoft\Auth\Http\Controllers\Controller;
use Arcanesoft\Auth\Policies\{PermissionsPolicy, RolesPolicy};
use Arcanesoft\Auth\Repositories\PermissionsRepository;
use Arcanesoft\Auth\Models\{Permission, Role};

/**
 * Class     RolesController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Permissions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Detach the given role from the permission.
     *
     * @param  \Arcanesoft\Auth\Models\Permission                  $permission
     * @param  \Arcanesoft\Auth\Http\Controllers\Permissions\Role  $role
     */
    public function detach(Permission $permission, Role $role, PermissionsRepository $repo)
    {
        $this->authorize(PermissionsPolicy::ability('roles.detach'), [$permission, $role]);

        $repo->detachRole($permission, $role);

        // TODO: Add notification

        return static::jsonResponseSuccess();
    }
}