<?php namespace Arcanesoft\Auth\Models\Presenters;

/**
 * Class     UserPresenter
 *
 * @package  Arcanesoft\Auth\Models\Observers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @property  string          full_name
 * @property  string          since_date
 * @property  string          gravatar
 * @property  string          formatted_last_activity
 *
 * @property  \Carbon\Carbon  last_activity
 * @property  \Carbon\Carbon  created_at
 */
trait UserPresenter
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasherTrait;

    /* -----------------------------------------------------------------
     |  Getters & Setters
     | -----------------------------------------------------------------
     */

    /**
     * Get the `full_name` attribute or use the username if empty.
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        $fullName = trim("{$this->first_name} {$this->last_name}");

        return empty($fullName) ? $this->username : $fullName;
    }

    /**
     * Get the `since_date` attribute (translated).
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
     * Get the `gravatar` attribute.
     *
     * @return string
     */
    public function getGravatarAttribute()
    {
        return gravatar()
            ->setDefaultImage('mm')->setSize(160)
            ->src($this->email);
    }

    /**
     * Get the `formatted_last_activity` attribute.
     *
     * @return string
     */
    public function getFormattedLastActivityAttribute()
    {
        return is_null($this->last_activity)
            ? trans('auth::users.no-activity')
            : $this->last_activity->diffForHumans();
    }
}
