<?php namespace Arcanesoft\Auth\Helpers;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     UserImpersonator
 *
 * @package  Arcanesoft\Auth\Helpers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UserImpersonator
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Start the user impersonation.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public static function start(User $user)
    {
        if ( ! $user->isMember()) return false;

        session()->put('impersonate', $user->id);

        return true;
    }

    /**
     * Stop the user impersonation.
     */
    public static function stop()
    {
        session()->forget('impersonate');
    }

    /**
     * Check if the impersonation is ongoing.
     *
     * @return bool
     */
    public static function isImpersonating()
    {
        return session()->has('impersonate');
    }

    /**
     * Check if the impersonation is enabled.
     *
     * @return bool
     */
    public static function isEnabled()
    {
        return config('arcanesoft.auth.impersonation.enabled');
    }
}
