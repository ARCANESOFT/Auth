<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\User as BaseUserModel;

/**
 * Class     User
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string  gravatar
 */
class User extends BaseUserModel
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the user hash id.
     *
     * @return string
     */
    public function getHashedIdAttribute()
    {
        return self::hasher()->encode($this->id);
    }

    /**
     * Get the full name attribute or use the username if empty.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $fullName = trim("{$this->first_name} {$this->last_name}");

        return empty($fullName) ? $this->username : $fullName;
    }

    /**
     * Get the gravatar attribute.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        return gravatar()
            ->setDefaultImage('mm')->setSize(160)
            ->src($this->email);
    }

    /**
     * Get the since date attribute (translated).
     *
     * @return string
     */
    public function getSinceDateAttribute()
    {
        return trans('auth::users.since', [
            'date' => $this->created_at->toFormattedDateString()
        ]);
    }

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
        $id = self::hasher()->decode($hashedId);

        return self::withTrashed()->where('id', $id)->firstOrFail();
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

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the hasher.
     *
     * @return \Arcanedev\Hasher\Contracts\HashManager
     */
    protected static function hasher()
    {
        return hasher();
    }
}
