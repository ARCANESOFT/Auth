<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Users;

use Arcanesoft\Auth\Models\User;

/**
 * Class     DetachedRoleFromUser
 *
 * @package  Arcanesoft\Auth\Events\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachedRoleFromUser extends UserEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\Models\Role|int */
    public $role;

    /** @var  int */
    public $results;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * DetachedRoleFromUser constructor.
     *
     * @param  \Arcanesoft\Auth\Models\User      $user
     * @param  \Arcanesoft\Auth\Models\Role|int  $role
     * @param  int                               $results
     */
    public function __construct(User $user, $role, $results)
    {
        parent::__construct($user);

        $this->role    = $role;
        $this->results = $results;
    }
}
