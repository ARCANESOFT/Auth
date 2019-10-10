<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers\Roles;

use Arcanesoft\Auth\Http\Controllers\Controller;
use Arcanesoft\Auth\Models\{Permission, Role};
use Arcanesoft\Auth\Policies\RolesPolicy;
use Arcanesoft\Auth\Repositories\RolesRepository;
use Illuminate\Http\JsonResponse;

/**
 * Class     PermissionsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * @param  \Arcanesoft\Auth\Models\Role                   $role
     * @param  \Arcanesoft\Auth\Models\Permission             $permission
     * @param  \Arcanesoft\Auth\Repositories\RolesRepository  $repository
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detach(Role $role, Permission $permission, RolesRepository $repo): JsonResponse
    {
        $this->authorize(RolesPolicy::ability('permissions.detach'), [$role, $permission]);

        $repo->detachPermission($role, $permission);

        // TODO: Add notification

        return static::jsonResponseSuccess();
    }
}