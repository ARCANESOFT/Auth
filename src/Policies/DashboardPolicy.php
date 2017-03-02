<?php namespace Arcanesoft\Auth\Policies;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     DashboardPolicy
 *
 * @package  Arcanesoft\Auth\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardPolicy extends AbstractPolicy
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */
    const PERMISSION_STATS = 'auth.dashboard.stats';

    /* -----------------------------------------------------------------
     |  Policies
     | -----------------------------------------------------------------
     */
    /**
     * Allow to access all the auth stats.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function statsPolicy(User $user)
    {
        return $user->may(static::PERMISSION_STATS);
    }
}
