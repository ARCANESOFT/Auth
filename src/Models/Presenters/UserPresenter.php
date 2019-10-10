<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Models\Presenters;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Class     UserPresenter
 *
 * @package  Arcanesoft\Auth\Models\Presenters
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property-read  string  full_name
 * @property-read  string  last_activity
 */
trait UserPresenter
{
    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Set the `first_name` attribute.
     *
     * @param  string  $firstName
     */
    public function setFirstNameAttribute($firstName)
    {
        $this->attributes['first_name'] = Str::title(Str::lower($firstName));
    }

    /**
     * Set the `last_name` attribute.
     *
     * @param  string  $lastName
     */
    public function setLastNameAttribute($lastName)
    {
        $this->attributes['last_name'] = Str::upper($lastName);
    }

    /**
     * Set the `email` attribute.
     *
     * @param  string  $email
     */
    public function setEmailAttribute($email)
    {
        $this->attributes['email'] = Str::lower($email);
    }

    /**
     * Set the `password` attribute.
     *
     * @param  string  $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Get the `full_name` attribute.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the `avatar` attribute.
     *
     * @return string
     */
    public function getAvatarAttribute(): string
    {
        return $this->attributes['avatar']
            ?? gravatar()
                ->setDefaultImage('blank')
                ->setSize(100)
                ->get($this->email);
    }

    /**
     * Get the last activity as human text.
     *
     * @return string
     */
    public function getLastActivityAttribute(): string
    {
        return is_null($this->last_activity_at)
            ? 'NULL'
            : $this->last_activity_at->diffForHumans();
    }
}
