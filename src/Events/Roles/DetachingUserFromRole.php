<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Roles;

use Arcanesoft\Auth\Models\Role;

/**
 * Class     DetachingUserFromRole
 *
 * @package  Arcanesoft\Auth\Events\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachingUserFromRole extends RoleEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\User|int */
    public $user;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * DetachedUserFromRole constructor.
     *
     * @param  \Arcanesoft\Auth\Models\Role      $role
     * @param  \Arcanesoft\Auth\Models\User|int  $user
     */
    public function __construct(Role $role, $user)
    {
        parent::__construct($role);

        $this->user    = $user;
    }
}
