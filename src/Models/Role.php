<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\Role as BaseRoleModel;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class     Role
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @method static \Illuminate\Database\Eloquent\Builder  admin()
 * @method static \Illuminate\Database\Eloquent\Builder  moderator()
 * @method static \Illuminate\Database\Eloquent\Builder  member()
 */
class Role extends BaseRoleModel
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */

    const ADMINISTRATOR = 'administrator';
    const MODERATOR     = 'moderator';
    const MEMBER        = 'member';

    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Presenters\RolePresenter;

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return parent::users()->protectAdmins();
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Scope only with administrator role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAdmin(Builder $query)
    {
        return $query->where('slug', Role::ADMINISTRATOR);
    }

    /**
     * Scope only with moderator role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeModerator(Builder $query)
    {
        return $query->where('slug', Role::MODERATOR);
    }

    /**
     * Scope only with member role.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMember(Builder $query)
    {
        return $query->where('slug', Role::MEMBER);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
        return self::withHashedId($hashedId)->firstOrFail();
    }

    /**
     * Make the slug.
     *
     * @param  string  $value
     *
     * @return string
     */
    public function makeSlugName($value)
    {
        return $this->slugify($value);
    }
}
