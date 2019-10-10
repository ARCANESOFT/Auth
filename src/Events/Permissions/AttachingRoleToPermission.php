<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Permissions;

use Arcanesoft\Auth\Models\Permission;

/**
 * Class     AttachingRoleToPermission
 *
 * @package  Arcanesoft\Auth\Events\Permissions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AttachingRoleToPermission extends PermissionEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\Role|int */
    public $role;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AttachingRoleToPermission constructor.
     *
     * @param  \Arcanesoft\Auth\Models\Permission  $permission
     * @param  \Arcanesoft\Auth\Models\Role|int    $role
     */
    public function __construct(Permission $permission, $role)
    {
        parent::__construct($permission);

        $this->role = $role;
    }
}