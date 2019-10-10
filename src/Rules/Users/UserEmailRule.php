<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Rules\Users;

use Arcanesoft\Auth\Auth;
use Illuminate\Validation\Rules\Unique;

/**
 * Class     UserEmailRule
 *
 * @package  Arcanesoft\Auth\Rules\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UserEmailRule
{
    /* -----------------------------------------------------------------
     |  Rules
     | -----------------------------------------------------------------
     */

    /**
     * Get the unique email rule.
     *
     * @return \Illuminate\Validation\Rules\Unique
     */
    public static function unique()
    {
        return new Unique(Auth::table('users'), 'email');
    }
}
