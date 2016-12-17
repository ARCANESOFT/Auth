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
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table   = 'password_resets';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden  = ['token'];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates   = [self::CREATED_AT];

    /* ------------------------------------------------------------------------------------------------
     |  Relationships
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The user relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
        return $this->created_at->lt(
            Carbon::now()->subMinutes(config('auth.passwords.users.expire', 60))
        );
    }
}
