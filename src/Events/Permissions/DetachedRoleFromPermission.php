<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Permissions;

use Arcanesoft\Auth\Models\Permission;

/**
 * Class     DetachedRoleFromPermission
 *
 * @package  Arcanesoft\Auth\Events\Permissions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachedRoleFromPermission extends PermissionEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\Role|int */
    public $role;

    /** @var  int */
    public $detached;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * DetachingRoleFromPermission constructor.
     *
     * @param  \Arcanesoft\Auth\Models\Permission  $permission
     * @param  \Arcanesoft\Auth\Models\Role|int    $role
     * @param  int                                 $detached
     */
    public function __construct(Permission $permission, $role, $detached)
    {
        parent::__construct($permission);

        $this->role     = $role;
        $this->detached = $detached;
    }
}
