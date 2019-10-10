<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Models\Concerns;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Models\Role;

/**
 * Trait     HasRoles
 *
 * @package  Arcanesoft\Auth\Models\Concerns
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  \Illuminate\Database\Eloquent\Collection  roles
 * @property  \Illuminate\Database\Eloquent\Collection  active_roles
 */
trait HasRoles
{
    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Roles' relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    abstract public function roles();

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the active roles collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getActiveRolesAttribute()
    {
        return $this->roles->filter(function (Role $role) {
            return $role->isActive();
        });
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if user has the given role (Role Model or Id).
     *
     * @param  \Arcanesoft\Auth\Models\Role|int  $id
     *
     * @return bool
     */
    public function hasRole($id): bool
    {
        $id = $id instanceof Role ? $id->getKey() : $id;

        return $this->active_roles->contains('id', $id);
    }

    /**
     * Check if has all roles.
     *
     * @param  \Illuminate\Support\Collection|array  $roles
     * @param  \Illuminate\Support\Collection        &$failed
     *
     * @return bool
     */
    public function isAll($roles, &$failed = null): bool
    {
        $this->isOne($roles, $failed);

        return $failed->isEmpty();
    }

    /**
     * Check if has at least one role.
     *
     * @param  \Illuminate\Support\Collection|array  $roles
     * @param  \Illuminate\Support\Collection        &$failed
     *
     * @return bool
     */
    public function isOne($roles, &$failed = null): bool
    {
        $roles = is_array($roles) ? collect($roles) : $roles;

        $failed = $roles->reject(function ($role) {
            return $this->hasRoleKey($role);
        })->values();

        return $roles->count() !== $failed->count();
    }

    /**
     * Check if has a role by its slug.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function hasRoleKey(string $key): bool
    {
        return $this->active_roles->filter(function (Role $role) use ($key) {
            return $role->hasKey($key);
        })->isNotEmpty();
    }
}
