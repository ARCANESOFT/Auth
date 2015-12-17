<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\Role as BaseRoleModel;

/**
 * Class     Role
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Role extends BaseRoleModel
{
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
        $id = head(hasher()->decode($hashedId));

        return self::where('id', $id)->firstOrFail();
    }
}
