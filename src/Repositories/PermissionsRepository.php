<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Repositories;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Events\Permissions\{DetachedRoleFromPermission, DetachingRoleFromPermission};
use Arcanesoft\Auth\Models\{Permission, Role};
use Illuminate\Support\Collection;

/**
 * Class     PermissionsRepository
 *
 * @package  Arcanesoft\Auth\Repositories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsRepository extends Repository
{
    /* -----------------------------------------------------------------
     |  Query Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the permission instance.
     *
     * @return \Arcanesoft\Auth\Models\Permission|mixed
     */
    public static function model()
    {
        return Auth::makeModel('permission');
    }

    /* -----------------------------------------------------------------
     |  CRUD Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get all the permissions' ids.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getAllIds(): Collection
    {
        return $this->pluck('id');
    }

    /**
     * Get first permission with the given uuid, or fails.
     *
     * @param  string  $uuid
     *
     * @return \Arcanesoft\Auth\Models\Permission|mixed
     */
    public function firstOrFailWhereUuid(string $uuid)
    {
        return $this->where('uuid', '=', $uuid)->firstOrFail();
    }

    /**
     * Get first role related to the permission by given uuid, or fail if not found.
     *
     * @param  \Arcanesoft\Auth\Models\Permission  $permission
     * @param  string                              $uuid
     */
    public function firstRoleWhereUuidOrFail(Permission $permission, string $uuid)
    {
        return $permission->roles()->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Get permissions' ids where in the given uuids.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getIdsWhereInUuid(array $uuids): Collection
    {
        return $this->whereIn('uuid', $uuids)->pluck('id');
    }

    /**
     * Detach role from permission.
     *
     * @param  \Arcanesoft\Auth\Models\Permission  $permission
     * @param  \Arcanesoft\Auth\Models\Role        $role
     *
     * @return int
     */
    public function detachRole(Permission $permission, Role $role): int
    {
        event(new DetachingRoleFromPermission($permission, $role));
        $detached = $permission->roles()->detach($role);
        event(new DetachedRoleFromPermission($permission, $role, $detached));

        return $detached;
    }
}
