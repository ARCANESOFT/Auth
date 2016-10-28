<?php namespace Arcanesoft\Auth\Models\Presenters;

/**
 * Class     UserPresenter
 *
 * @package  Arcanesoft\Auth\Models\Observers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string          gravatar
 * @property  string          hashed_id
 * @property  \Carbon\Carbon  created_at
 */
trait UserPresenter
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use HasherTrait;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the full name attribute or use the username if empty.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $fullName = trim("{$this->first_name} {$this->last_name}");

        return empty($fullName) ? $this->username : $fullName;
    }

    /**
     * Get the since date attribute (translated).
     *
     * @return string
     */
    public function getSinceDateAttribute()
    {
        return trans('auth::users.since', [
            'date' => $this->created_at->toFormattedDateString()
        ]);
    }

    /**
     * Get the gravatar attribute.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        return gravatar()
            ->setDefaultImage('mm')->setSize(160)
            ->src($this->email);
    }
}
