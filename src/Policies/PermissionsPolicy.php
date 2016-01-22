<?php namespace Arcanesoft\Auth\Policies;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     PermissionsPolicy
 *
 * @package  Arcanesoft\Auth\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsPolicy
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters and Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the policies.
     *
     * @return array
     */
    public static function getPolicies()
    {
        return [
            'listPolicy'   => 'auth.permissions.list',
            'showPolicy'   => 'auth.permissions.show',
            'updatePolicy' => 'auth.permissions.update',
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Allow to list all the roles.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function listPolicy(User $user)
    {
        return $user->may('auth.permissions.list');
    }

    /**
     * Allow to show a role details.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function showPolicy(User $user)
    {
        return $user->may('auth.permissions.show');
    }

    /**
     * Allow to update a role.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function updatePolicy(User $user)
    {
        return $user->may('auth.permissions.update');
    }
}
