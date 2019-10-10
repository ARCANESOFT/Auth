<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Permissions;

use Arcanesoft\Auth\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class     SyncingRolesToPermission
 *
 * @package  Arcanesoft\Auth\Events\Permissions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SyncingRolesToPermission extends PermissionEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Illuminate\Database\Eloquent\Collection */
    public $roles;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * SyncingRolesToPermission constructor.
     *
     * @param  \Arcanesoft\Auth\Models\Permission        $permission
     * @param  \Illuminate\Database\Eloquent\Collection  $roles
     */
    public function __construct(Permission $permission, Collection $roles)
    {
        parent::__construct($permission);

        $this->roles = $roles;
    }
}
