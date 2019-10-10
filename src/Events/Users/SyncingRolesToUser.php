<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Users;

use Arcanesoft\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class     SyncingRolesToUser
 *
 * @package  Arcanesoft\Auth\Events\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SyncingRolesToUser extends UserEvent
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
     * SyncingRolesToUser constructor.
     *
     * @param  \Arcanesoft\Auth\Models\User              $user
     * @param  \Illuminate\Database\Eloquent\Collection  $roles
     */
    public function __construct(User $user, Collection $roles)
    {
        parent::__construct($user);

        $this->roles = $roles;
    }
}
