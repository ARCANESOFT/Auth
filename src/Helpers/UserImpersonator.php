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

    public static function stop()
    {
        session()->forget('impersonate');
    }

    public static function isImpersonating()
    {
        return session()->has('impersonate');
    }
}
