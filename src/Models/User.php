<?php namespace Arcanesoft\Auth\Models;

use Arcanedev\LaravelAuth\Models\User as BaseUserModel;

/**
 * Class     User
 *
 * @package  Arcanesoft\Auth\Models
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string  gravatar
 */
class User extends BaseUserModel
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the gravatar attribute.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        return gravatar()
            ->setDefaultImage('mm')
            ->setSize(160)
            ->src($this->email, $this->username);
    }
}
