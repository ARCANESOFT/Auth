<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\PermissionsGroups;

use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;

/**
 * Class     AttachedPermissionToGroup
 *
 * @package  Arcanesoft\Auth\Events\PermissionsGroups
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AttachedPermissionToGroup extends PermissionsGroupEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\Permission|mixed */
    public $permission;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AttachedPermissionToGroup constructor.
     *
     * @param  \Arcanesoft\Auth\Models\PermissionsGroup  $group
     * @param  \Arcanesoft\Auth\Models\Permission|mixed  $permission
     */
    public function __construct(PermissionsGroup $group, $permission)
    {
        parent::__construct($group);

        $this->permission = $permission;
    }
}
