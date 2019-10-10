<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Permissions;

use Arcanesoft\Auth\Models\Permission;

/**
 * Class     DetachedAllRolesFromPermission
 *
 * @package  Arcanesoft\Auth\Events\Permissions
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachedAllRolesFromPermission extends PermissionEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  int */
    public $results;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * DetachedAllRolesFromPermission constructor.
     *
     * @param  \Arcanesoft\Auth\Models\Permission  $permission
     * @param  int                                 $results
     */
    public function __construct(Permission $permission, $results)
    {
        parent::__construct($permission);

        $this->results = $results;
    }
}
