<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Roles;

use Arcanesoft\Auth\Models\Role;

/**
 * Class     SyncedPermissionsToRole
 *
 * @package  Arcanesoft\Auth\Events\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SyncedPermissionsToRole extends RoleEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * Permissions' ids.
     *
     * @var array
     */
    public $ids;

    /**
     * The synced result.
     *
     * @var array
     */
    public $synced;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * RoleEvent constructor.
     *
     * @param  \Arcanesoft\Auth\Models\Role  $role
     * @param  array                         $ids
     * @param  array                         $synched
     */
    public function __construct(Role $role, array $ids, array $synched)
    {
        parent::__construct($role);

        $this->ids    = $ids;
        $this->synced = $synched;
    }
}
