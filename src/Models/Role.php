<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\Role as BaseRoleModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class     Role
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @method static \Illuminate\Database\Eloquent\Builder  admins()
 * @method static \Illuminate\Database\Eloquent\Builder  members()
 */
class Role extends BaseRoleModel
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const ADMINISTRATOR = 'administrator';
    const MEMBER        = 'member';

    /* ------------------------------------------------------------------------------------------------
     |  Scopes
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Scope only admin roles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmins(Builder $query)
    {
        return $query->where('slug', Role::ADMINISTRATOR);
    }

    /**
     * Scope only admin roles.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMembers(Builder $query)
    {
        return $query->where('slug', Role::MEMBER);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the role hash id.
     *
     * @return string
     */
    public function getHashedIdAttribute()
    {
        return hasher()->encode($this->id);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get a role from a hashed id or fail if not found.
     *
     * @param  string  $hashedId
     *
     * @return self
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function firstHashedOrFail($hashedId)
    {
        $id = head(hasher()->decode($hashedId));

        return self::where('id', $id)->firstOrFail();
    }

    /**
     * @param  string  $value
     *
     * @return string
     */
    public function makeSlugName($value)
    {
        return $this->slugify($value);
    }
}
