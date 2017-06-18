<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\User as BaseUserModel;
use Arcanedev\LaravelImpersonator\Contracts\Impersonatable;
use Arcanedev\LaravelImpersonator\Traits\CanImpersonate;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class     User
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  \Arcanesoft\Auth\Models\PasswordReset  passwordReset
 */
class User extends BaseUserModel implements Impersonatable
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use Presenters\UserPresenter,
        CanImpersonate;

    /* -----------------------------------------------------------------
     |  Relationships
     | -----------------------------------------------------------------
     */

    /**
     * Password reset relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function passwordReset()
    {
        return $this->hasOne(PasswordReset::class, 'email', 'email');
    }

    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */

    /**
     * Protect admins.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeProtectAdmins(Builder $query)
    {
        /** @var self $user */
        $user = auth()->user();

        return ($user && $user->is_admin)
            ? $query
            : $query->where('is_admin', false);
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
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
        return self::withTrashed()->protectAdmins()->withHashedId($hashedId)->firstOrFail();
    }

    /* -----------------------------------------------------------------
     |  Check Methods
     | -----------------------------------------------------------------
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

    /**
     * Check if user has a password reset.
     *
     * @return bool
     */
    public function hasPasswordReset()
    {
        return ! is_null($this->passwordReset);
    }

    /**
     * Check if the current modal can impersonate other models.
     *
     * @return  bool
     */
    public function canImpersonate()
    {
        return impersonator()->isEnabled() && $this->isAdmin();
    }

    /**
     * Check if the current model can be impersonated.
     *
     * @return  bool
     */
    public function canBeImpersonated()
    {
        return impersonator()->isEnabled() && ! $this->isAdmin();
    }
}
