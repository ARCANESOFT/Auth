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
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */
    use Presenters\PermissionsGroupPresenter;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
        return self::withHashedId($hashedId)->firstOrFail();
    }
}
