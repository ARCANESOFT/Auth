<?php namespace Arcanesoft\Auth\Models;

use \Arcanedev\LaravelAuth\Models\PermissionsGroup as BasePermissionsGroupModel;

/**
 * Class     PermissionsGroup
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string  hashed_id
 */
class PermissionsGroup extends BasePermissionsGroupModel
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the permissions group hash id.
     *
     * @return string
     */
    public function getHashedIdAttribute()
    {
        return self::hasher()->encode($this->id);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Function
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get a permission from a hashed id or fail if not found.
     *
     * @param  string  $hashedId
     *
     * @return self
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public static function firstHashedOrFail($hashedId)
    {
        $id = static::hasher()->decode($hashedId);

        return self::where('id', $id)->firstOrFail();
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
    public static function hasher()
    {
        return hasher();
    }
}
