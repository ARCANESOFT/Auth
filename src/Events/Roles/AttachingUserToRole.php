<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Roles;

use Arcanesoft\Auth\Models\Role;

/**
 * Class     AttachingUserToRole
 *
 * @package  Arcanesoft\Auth\Events\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AttachingUserToRole extends RoleEvent
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
     * AttachedUserToRole constructor.
     *
     * @param  \Arcanesoft\Auth\Models\Role      $role
     * @param  \Arcanesoft\Auth\Models\User|int  $user
     */
    public function __construct(Role $role, $user)
    {
        parent::__construct($role);

        $this->user = $user;
    }
}
