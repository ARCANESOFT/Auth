<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Users;

use Arcanesoft\Auth\Models\User;

/**
 * Class     DetachedRolesFromUser
 *
 * @package  Arcanesoft\Auth\Events\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DetachedRolesFromUser extends UserEvent
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
     * DetachedRolesFromUser constructor.
     *
     * @param  \Arcanesoft\Auth\Models\User  $user
     * @param  int                           $results
     */
    public function __construct(User $user, $results)
    {
        parent::__construct($user);

        $this->results = $results;
    }
}
