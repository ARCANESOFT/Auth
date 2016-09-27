<?php namespace Arcanesoft\Auth\Policies;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     DashboardPolicy
 *
 * @package  Arcanesoft\Auth\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardPolicy extends Policy
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const PERMISSION_STATS = 'auth.dashboard.stats';

    /* ------------------------------------------------------------------------------------------------
     |  Getters and Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the policies.
     *
     * @return array
     */
    public static function getPolicies()
    {
        return [
            'statsPolicy' => static::PERMISSION_STATS,
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies Functions
     | ------------------------------------------------------------------------------------------------
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
