<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\Permission as BasePermissionModel;

/**
 * Class     Permission
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Permission extends BasePermissionModel
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
        $id = head(hasher()->decode($hashedId));

        return self::where('id', $id)->firstOrFail();
    }
}
