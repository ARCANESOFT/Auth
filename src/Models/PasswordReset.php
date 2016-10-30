<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\Support\Bases\Model;
use Carbon\Carbon;

/**
 * Class     PasswordReset
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string                        email
 * @property  string                        token
 * @property  \Carbon\Carbon                created_at
 * @property  \Arcanesoft\Auth\Models\User  user
 */
class PasswordReset extends Model
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    protected $table   = 'password_resets';

    protected $hidden  = ['token'];

    public $timestamps = false;

    protected $dates   = [self::CREATED_AT];

    /* ------------------------------------------------------------------------------------------------
     |  Relationships
     | ------------------------------------------------------------------------------------------------
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the token repository.
     *
     * @return \Illuminate\Auth\Passwords\TokenRepositoryInterface
     */
    public static function getTokenRepository()
    {
        return app('auth.password')->getRepository();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if the password reset was expired.
     *
     * @return bool
     */
    public function isExpired()
    {
        $expiredAt = Carbon::now()->subMinutes(
            config('auth.passwords.users.expire', 60)
        );

        return $this->created_at->lt($expiredAt);
    }
}
