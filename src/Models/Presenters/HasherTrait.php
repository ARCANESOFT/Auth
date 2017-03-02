<?php namespace Arcanesoft\Auth\Models\Presenters;

use Illuminate\Database\Eloquent\Builder;

/**
 * Class     HasherTrait
 *
 * @package  Arcanesoft\Auth\Models\Presenters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  int     id
 * @property  string  hashed_id
 *
 * @method  static  \Illuminate\Database\Eloquent\Builder  withHashedId(string $hashedId)
 */
trait HasherTrait
{
    /* -----------------------------------------------------------------
     |  Scopes
     | -----------------------------------------------------------------
     */
    /**
     * Scope with the hashed id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string                                 $hashedId
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithHashedId(Builder $query, $hashedId)
    {
        return $query->where('id', self::decodeHashedId($hashedId));
    }

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */
    /**
     * Get the model hash id.
     *
     * @return string
     */
    public function getHashedIdAttribute()
    {
        return self::hasher()->encode($this->id);
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
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

    /**
     * Decode the hashed id.
     *
     * @param  string  $hashedId
     *
     * @return int
     */
    protected static function decodeHashedId($hashedId)
    {
        return self::hasher()->decode($hashedId);
    }
}
