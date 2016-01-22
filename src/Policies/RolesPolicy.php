<?php namespace Arcanesoft\Auth\Policies;

use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     RolesPolicy
 *
 * @package  Arcanesoft\Auth\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesPolicy
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
            'listPolicy'   => 'auth.roles.list',
            'showPolicy'   => 'auth.roles.show',
            'createPolicy' => 'auth.roles.create',
            'updatePolicy' => 'auth.roles.update',
            'deletePolicy' => 'auth.roles.delete',
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
        return $user->may('auth.roles.list');
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
        return $user->may('auth.roles.show');
    }

    /**
     * Allow to create a role.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function createPolicy(User $user)
    {
        return $user->may('auth.roles.create');
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
        return $user->may('auth.roles.update');
    }

    /**
     * Allow to delete a role.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function deletePolicy(User $user)
    {
        return $user->may('auth.roles.delete');
    }
}
