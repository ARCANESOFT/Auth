<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Repositories;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Models\{Role, Permission, User};
use Arcanesoft\Auth\Events\Roles\{
    DetachedAllUsersFromRole, DetachedPermissionFromRole, DetachedUserFromRole, DetachingAllPermissionsFromRole,
    DetachedAllPermissionsFromRole, DetachingAllUsersFromRole, DetachingPermissionFromRole, DetachingUserFromRole,
    SyncedPermissionsToRole, SyncingPermissionsToRole
};

/**
 * Class     RolesRepository
 *
 * @package  Arcanesoft\Auth\Repositories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @mixin  \Arcanesoft\Auth\Models\Role
 */
class RolesRepository extends Repository
{
    /* -----------------------------------------------------------------
     |  Query Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the model instance.
     *
     * @return \Arcanesoft\Auth\Models\Role|mixed
     */
    public static function model()
    {
        return Auth::makeModel('role');
    }

    /* -----------------------------------------------------------------
     |  CRUD Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the admin role.
     *
     * @return \Arcanesoft\Auth\Models\Role|mixed
     */
    public function getAdminRole(): Role
    {
        return $this->admin()->first();
    }

    /**
     * Get first role with the given key, or fails if not found.
     *
     * @param  string  $key
     *
     * @return \Arcanesoft\Auth\Models\Role|mixed
     */
    public function firstWithKeyOrFail(string $key): Role
    {
        return $this->where('key', '=', $key)
                    ->firstOrFail();
    }

    /**
     * Get first role by the given uuid, or fails if not found.
     *
     * @param  string  $uuid
     *
     * @return \Arcanesoft\Auth\Models\Role|mixed
     */
    public function firstWithUuidOrFail(string $uuid)
    {
        return $this->where('uuid', '=', $uuid)
                    ->firstOrFail();
    }

    /**
     * Get first related user by the given uuid, or fails if not found.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     * @param  string                        $uuid
     *
     * @return \Arcanesoft\Auth\Models\User|mixed
     */
    public function firstUserWithUuidOrFail(Role $role, string $uuid)
    {
        return $role->users()
                    ->where('uuid', '=', $uuid)
                    ->withTrashed() // Get also trashed records
                    ->firstOrFail();
    }

    /**
     * Get first related permission by the given uuid, or fails if not found.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     * @param  string                        $uuid
     *
     * @return \Arcanesoft\Auth\Models\Permission|mixed
     */
    public function firstPermissionWithUuidOrFail(Role $role, string $uuid)
    {
        return $role->permissions()
                    ->where('uuid', '=', $uuid)
                    ->firstOrFail();
    }

    /**
     * Get roles with the given list of `key` (attribute).
     *
     * @param  array  $keys
     *
     * @return \Arcanesoft\Auth\Models\Role[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getByKeys(array $keys)
    {
        return $this->whereIn('key', $keys)->get();
    }

    /**
     * Get roles with the given list of `uuid` (attribute).
     *
     * @param  array  $uuids
     *
     * @return \Arcanesoft\Auth\Models\Role[]|\Illuminate\Database\Eloquent\Collection|mixed
     */
    public function getByUuids($uuids)
    {
        return $this->whereIn('uuid', $uuids)->get();
    }

    /**
     * Update the given role.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     * @param  array                         $attributes
     *
     * @return bool
     */
    public function update(Role $role, array $attributes): bool
    {
        return $role->update($attributes);
    }

    /**
     * Sync permissions by the given uuids.
     *
     * @param  \Arcanesoft\Auth\Models\Role|mixed  $role
     * @param  array                               $uuids
     *
     * @return array
     */
    public function syncPermissionsByUuids(Role $role, array $uuids): array
    {
        $ids = static::getRepository(PermissionsRepository::class)
            ->getIdsWhereInUuid($uuids)
            ->toArray();

        return $this->syncPermissionsByIds($role, $ids);
    }

    /**
     * Sync the permissions by the given ids.
     *
     * @param  \Arcanesoft\Auth\Models\Role|mixed  $role
     * @param  array                               $ids
     *
     * @return array
     */
    public function syncPermissionsByIds(Role $role, array $ids): array
    {
        if (empty($ids))
            return [];

        event(new SyncingPermissionsToRole($role, $ids));
        $synced = $role->permissions()->sync($ids);
        event(new SyncedPermissionsToRole($role, $ids, $synced));

        return $synced;
    }

    /**
     * Deteach the given permission from role.
     *
     * @param  \Arcanesoft\Auth\Models\Role        $role
     * @param  \Arcanesoft\Auth\Models\Permission  $permission
     *
     * @return int
     */
    public function detachPermission(Role $role, Permission $permission): int
    {
        event(new DetachingPermissionFromRole($role, $permission));
        $detached = $role->permissions()->detach($permission);
        event(new DetachedPermissionFromRole($role, $permission, $detached));

        return $detached;
    }

    /**
     * Detach all the permissions from the given role.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     *
     * @return int
     */
    public function detachAllPermissions(Role $role): int
    {
        event(new DetachingAllPermissionsFromRole($role));
        $detached = $role->permissions()->detach();
        event(new DetachedAllPermissionsFromRole($role, $detached));

        return $detached;
    }

    /**
     * Deteach the given user from role.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     * @param  \Arcanesoft\Auth\Models\User  $user
     *
     * @return int
     */
    public function detachUser(Role $role, User $user): int
    {
        event(new DetachingUserFromRole($role, $user));
        $detached = $role->users()->detach($user);
        event(new DetachedUserFromRole($role, $user, $detached));

        return $detached;
    }

    /**
     * Detach all the users from the given role.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     *
     * @return int
     */
    public function detachAllUsers(Role $role): int
    {
        event(new DetachingAllUsersFromRole($role));
        $detached = $role->users()->detach();
        event(new DetachedAllUsersFromRole($role, $detached));

        return $detached;
    }

    /**
     * Get the active roles count.
     *
     * @return int
     */
    public function activeCount()
    {
        return $this->activated()->count();
    }

    /**
     * Activate/Deactivate the given role.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     *
     * @return bool
     */
    public function toggleActive(Role $role): bool
    {
        return $role->isActive() ? $role->deactivate() : $role->activate();
    }

    /**
     * Delete the given role.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     *
     * @return bool|null
     */
    public function delete(Role $role)
    {
        return $role->delete();
    }

    /**
     * Get the roles filtered by authenticated user.
     * If the user is a super admin shows all the roles.
     *
     * @return \Arcanesoft\Auth\Models\Role[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getFilteredByAuthenticatedUser(User $user)
    {
        return $this->get()->filter(function (Role $role) use ($user) {
            if ($user->isSuperAdmin())
                return false;

            return $role->key !== Role::ADMINISTRATOR;
        });
    }
}
