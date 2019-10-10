<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Policies;

use App\Models\User as AuthenticatedUser;
use Arcanesoft\Auth\Models\User;
use Arcanesoft\Foundation\Core\Auth\Policy;

/**
 * Class     UsersPolicy
 *
 * @package  Arcanesoft\Auth\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * TODO: Check the abilities
 */
class UsersPolicy extends Policy
{
    /* -----------------------------------------------------------------
     |  Getters
     | -----------------------------------------------------------------
     */

    /**
     * Get the ability's prefix.
     *
     * @return string
     */
    protected static function prefix(): string
    {
        return 'admin::auth.users.';
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Get the policy's abilities.
     *
     * @return \Arcanedev\LaravelPolicies\Ability[]|iterable
     */
    public function abilities(): iterable
    {
        $this->setMetas([
            'category' => 'Users',
        ]);

        return [

            // admin::auth.users.index
            $this->makeAbility('index')->setMetas([
                'name'        => 'List all the users',
                'description' => 'Ability to list all the users'
            ]),

            // admin::auth.users.metrics
            $this->makeAbility('metrics')->setMetas([
                'name'        => "List all the users' metrics",
                'description' => "Ability to list all the users' metrics",
            ]),

            // admin::auth.users.show
            $this->makeAbility('show')->setMetas([
                'name'        => 'Show a user',
                'description' => "Ability to show the user's details",
            ]),

            // admin::auth.users.create
            $this->makeAbility('create')->setMetas([
                'name'        => 'Create a new user',
                'description' => 'Ability to create a new user',
            ]),

            // admin::auth.users.update
            $this->makeAbility('update')->setMetas([
                'name'        => 'Update a user',
                'description' => 'Ability to update a user',
            ]),

            // admin::auth.users.activate
            $this->makeAbility('activate')->setMetas([
                'name'        => 'Activate/Deactivate a user',
                'description' => 'Ability to activate/deactivate a user',
            ]),

            // admin::auth.users.delete
            $this->makeAbility('delete')->setMetas([
                'name'        => 'Delete a user',
                'description' => 'Ability to delete a user',
            ]),

            // admin::auth.users.force-delete
            $this->makeAbility('force-delete')->setMetas([
                'name'        => 'Force Delete a user',
                'description' => 'Ability to force delete a user',
            ]),

            // admin::auth.users.restore
            $this->makeAbility('restore')->setMetas([
                'name'        => 'Restore a user',
                'description' => 'Ability to restore a user',
            ]),

            // admin::auth.users.impersonate
            $this->makeAbility('impersonate')->setMetas([
                'name'        => 'Impersonate a user',
                'description' => 'Ability to impersonate a user',
            ]),
        ];
    }

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    /**
     * Allow to list all the users.
     *
     * @param  \App\Models\User|mixed  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function index(AuthenticatedUser $user)
    {
        //
    }

    /**
     * Allow to list all the users' metrics.
     *
     * @param  \App\Models\User|mixed  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function metrics(AuthenticatedUser $user)
    {
        //
    }

    /**
     * Allow to show a user details.
     *
     * @param  \App\Models\User|mixed  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function show(AuthenticatedUser $user, User $model = null)
    {
        if ($model && $model->isSuperAdmin() && ! $user->isSuperAdmin())
            return false;
    }

    /**
     * Allow to create a user.
     *
     * @param  \App\Models\User|mixed  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function create(AuthenticatedUser $user)
    {
        //
    }

    /**
     * Allow to update a user.
     *
     * @param  \App\Models\User                   $user
     * @param  \Arcanesoft\Auth\Models\User|null  $model
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function update(AuthenticatedUser $user, User $model = null)
    {
        //
    }

    /**
     * Allow to update a user.
     *
     * @param  \App\Models\User                   $user
     * @param  \Arcanesoft\Auth\Models\User|null  $model
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function activate(AuthenticatedUser $user, User $model = null)
    {
        if ($user->is($model))
            return false;

        if ( ! is_null($model) && $model->isSuperAdmin())
            return false;
    }

    /**
     * Allow to delete a user.
     *
     * @param  \App\Models\User                   $user
     * @param  \Arcanesoft\Auth\Models\User|null  $model
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function delete(AuthenticatedUser $user, User $model = null)
    {
        if ($user->is($model))
            return false;

        if ( ! is_null($model))
            return $model->isDeletable();
    }

    /**
     * Allow to force delete a user.
     *
     * @param  \App\Models\User                   $user
     * @param  \Arcanesoft\Auth\Models\User|null  $model
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function forceDelete(AuthenticatedUser $user, User $model = null)
    {
        if ( ! is_null($model))
            return $model->isDeletable();
    }

    /**
     * Allow to restore a user.
     *
     * @param  \App\Models\User                   $user
     * @param  \Arcanesoft\Auth\Models\User|null  $model
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function restore(AuthenticatedUser $user, User $model = null)
    {
        if ( ! is_null($model))
            return $model->trashed();
    }

    /**
     * Allow to impersonate a user.
     *
     * @param  \App\Models\User                   $user
     * @param  \Arcanesoft\Auth\Models\User|null  $model
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function impersonate(AuthenticatedUser $user, User $model)
    {
        if ($model->isAdmin())
            return false;

        return $user->isNot($model);
    }
}
