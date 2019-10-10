<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Events\Users;

use Arcanesoft\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class     SyncedRolesToUser
 *
 * @package  Arcanesoft\Auth\Events\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SyncedRolesToUser extends UserEvent
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Illuminate\Database\Eloquent\Collection */
    public $roles;

    /** @var  array */
    public $synced;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * SyncedRolesToUser constructor.
     *
     * @param  \Arcanesoft\Auth\Models\User              $user
     * @param  \Illuminate\Database\Eloquent\Collection  $roles
     * @param  array                                     $synced
     */
    public function __construct(User $user, Collection $roles, array $synced)
    {
        parent::__construct($user);

        $this->roles  = $roles;
        $this->synced = $synced;
    }
}
