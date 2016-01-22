<?php namespace Arcanesoft\Auth\Policies;
use Arcanesoft\Contracts\Auth\Models\User;

/**
 * Class     UsersPolicy
 *
 * @package  Arcanesoft\Auth\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersPolicy
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
            'listPolicy'   => 'auth.users.list',
            'showPolicy'   => 'auth.users.show',
            'createPolicy' => 'auth.users.create',
            'updatePolicy' => 'auth.users.update',
            'deletePolicy' => 'auth.users.delete',
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Policies Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Allow to list all the users.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function listPolicy(User $user)
    {
        return $user->may('auth.users.list');
    }

    /**
     * Allow to show a user details.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function showPolicy(User $user)
    {
        return $user->may('auth.users.show');
    }

    /**
     * Allow to create a user.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function createPolicy(User $user)
    {
        return $user->may('auth.users.create');
    }

    /**
     * Allow to update a user.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function updatePolicy(User $user)
    {
        return $user->may('auth.users.update');
    }

    /**
     * Allow to delete a user.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return bool
     */
    public function deletePolicy(User $user)
    {
        return $user->may('auth.users.delete');
    }
}
