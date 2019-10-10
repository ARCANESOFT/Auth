<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\PermissionsGroups;

use Arcanesoft\Auth\Models\PermissionsGroup;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class     AttachedPermissionsToGroup
 *
 * @package  Arcanesoft\Auth\Events\PermissionsGroups
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AttachedPermissionsToGroup extends PermissionsGroupEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \iterable */
    public $permissions;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AttachedPermissionsToGroup constructor.
     *
     * @param  \Arcanesoft\Auth\Models\PermissionsGroup  $group
     * @param  \iterable                                 $permissions
     */
    public function __construct(PermissionsGroup $group, $permissions)
    {
        parent::__construct($group);

        $this->permissions = $permissions;
    }
}
