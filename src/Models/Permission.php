<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\Permission as BasePermission;

/**
 * Class     Permission
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int|null  roles_count
 *
 * @mixin  \Illuminate\Database\Eloquent\Builder
 */
class Permission extends BasePermission
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Presenters\PermissionPresenter;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get a permission from a hashed id or fail if not found.
     *
     * @param  string  $hashedId
     *
     * @return self
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function firstHashedOrFail($hashedId)
    {
        return self::withHashedId($hashedId)->firstOrFail();
    }

    /**
     * Get the ids of all permissions.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function getIds()
    {
        return self::query()->orderBy('id')->pluck('id');
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
     */

    /**
     * Check if permission has a group.
     *
     * @return bool
     */
    public function hasGroup()
    {
        return $this->group_id > 0;
    }
}
