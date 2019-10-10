<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Repositories;

use Arcanesoft\Auth\Auth;
use Arcanesoft\Auth\Models\PermissionsGroup;

/**
 * Class     PermissionsGroupsRepository
 *
 * @package  Arcanesoft\Auth\Repositories
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsGroupsRepository extends Repository
{
    /* -----------------------------------------------------------------
     |  Query Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the permission instance.
     *
     * @return \Arcanesoft\Auth\Models\PermissionsGroup|mixed
     */
    public static function model()
    {
        return Auth::makeModel('permissions-group', PermissionsGroup::class);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Save permissions to the group.
     *
     * @param  \Arcanesoft\Auth\Models\PermissionsGroup       $group
     * @param  \Arcanesoft\Auth\Models\Permission[]|iterable  $permissions
     *
     * @return iterable
     */
    public function savePermissions(PermissionsGroup $group, iterable $permissions)
    {
        return $group->permissions()->saveMany($permissions);
    }
}