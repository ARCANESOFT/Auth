<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\User as BaseUserModel;

/**
 * Class     User
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class User extends BaseUserModel
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Presenters\UserPresenter;

    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get a user from a hashed id or fail if not found.
     *
     * @param  string  $hashedId
     *
     * @return self
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function firstHashedOrFail($hashedId)
    {
        return self::withTrashed()->withHashedId($hashedId)->firstOrFail();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if user is an administrator.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return parent::isAdmin() || $this->hasRoleSlug(Role::ADMINISTRATOR);
    }

    /**
     * Check if user is a moderator.
     *
     * @return bool
     */
    public function isModerator()
    {
        return $this->hasRoleSlug(Role::MODERATOR);
    }

    /**
     * Check if user is a member.
     *
     * @return bool
     */
    public function isMember()
    {
        return $this->hasRoleSlug(Role::MEMBER);
    }
}
