<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Users;

use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\User;

/**
 * Class     AttachedRoleToUser
 *
 * @package  Arcanesoft\Auth\Events\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AttachedRoleToUser extends UserEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\Role */
    public $role;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * AttachedRoleToUser constructor.
     *
     * @param  \Arcanesoft\Auth\Models\User  $user
     * @param  \Arcanesoft\Auth\Models\Role  $role
     */
    public function __construct(User $user, Role $role)
    {
        parent::__construct($user);

        $this->role = $role;
    }
}
