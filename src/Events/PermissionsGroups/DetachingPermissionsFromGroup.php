<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\PermissionsGroups;

use Arcanesoft\Auth\Models\PermissionsGroup;

/**
 * Class     DetachingPermissionsFromGroup
 *
 * @package  Arcanesoft\Auth\Events\PermissionsGroups
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachingPermissionsFromGroup extends PermissionsGroupEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  array */
    public $permissionIds;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * DetachingPermissionsFromGroup constructor.
     *
     * @param  \Arcanesoft\Auth\Models\PermissionsGroup  $group
     * @param  array                                     $permissionIds
     */
    public function __construct(PermissionsGroup $group, array $permissionIds)
    {
        parent::__construct($group);

        $this->permissionIds = $permissionIds;
    }
}
