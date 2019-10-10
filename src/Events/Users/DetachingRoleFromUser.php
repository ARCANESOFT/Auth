<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Users;

use Arcanesoft\Auth\Models\User;

/**
 * Class     DetachingRoleFromUser
 *
 * @package  Arcanesoft\Auth\Events\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachingRoleFromUser extends UserEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\Role|int */
    public $role;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * DetachedRoleFromUser constructor.
     *
     * @param  \Arcanesoft\Auth\Models\User      $user
     * @param  \Arcanesoft\Auth\Models\Role|int  $role
     */
    public function __construct(User $user, $role)
    {
        parent::__construct($user);

        $this->role = $role;
    }
}
