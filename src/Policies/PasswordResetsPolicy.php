<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Policies;

use App\Models\User as AuthenticatedUser;
use Arcanesoft\Foundation\Core\Auth\Policy;

/**
 * Class     PasswordResetsPolicy
 *
 * @package  Arcanesoft\Auth\Policies
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsPolicy extends Policy
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
        return 'admin::auth.password-resets.';
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
            'category' => 'Password Resets',
        ]);

        return [

            // admin::auth.password-resets.index
            $this->makeAbility('index')->setMetas([
                'name'        => 'List all the password resets',
                'description' => 'Ability to list all the password resets',
            ]),

            // admin::auth.password-resets.metrics
            $this->makeAbility('metrics')->setMetas([
                'name'        => "List all the password resets' metrics",
                'description' => "Ability to list all the password resets' metrics",
            ]),

            // admin::auth.password-resets.delete
            $this->makeAbility('delete')->setMetas([
                'name'        => 'Delete a password reset',
                'description' => 'Ability to delete a password reset',
            ]),
            
        ];
    }

    /* -----------------------------------------------------------------
     |  Abilities
     | -----------------------------------------------------------------
     */

    /**
     * Allow to list all the password resets.
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
     * Allow to access the password resets' metrics.
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
     * Allow to delete a password reset.
     *
     * @param  \App\Models\User|mixed  $user
     *
     * @return \Illuminate\Auth\Access\Response|bool|void
     */
    public function delete(AuthenticatedUser $user)
    {
        //
    }
}
