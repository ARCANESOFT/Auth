<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\PasswordReset as BasePasswordReset;

/**
 * Class     PasswordReset
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  \Arcanesoft\Auth\Models\User  user
 */
class PasswordReset extends BasePasswordReset
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Delete all the records.
     *
     * @return mixed
     */
    public static function deleteAll()
    {
        return self::query()->delete();
    }

    /**
     * Delete all the expired password resets.
     */
    public static function deleteExpired()
    {
        PasswordReset::getTokenRepository()->deleteExpired();
    }
}
