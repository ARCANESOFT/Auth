<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers\Roles;

use Arcanesoft\Auth\Http\Controllers\Controller;
use Arcanesoft\Auth\Policies\RolesPolicy;
use Illuminate\Http\JsonResponse;
use Arcanesoft\Auth\Models\{Role, User};
use Arcanesoft\Auth\Repositories\RolesRepository;

/**
 * Class     UsersController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersController extends Controller
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * @param  \Arcanesoft\Auth\Models\Role                   $role
     * @param  \Arcanesoft\Auth\Models\User                   $user
     * @param  \Arcanesoft\Auth\Repositories\RolesRepository  $repo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function detach(Role $role, User $user, RolesRepository $repo): JsonResponse
    {
        $this->authorize(RolesPolicy::ability('users.detach'), [$role, $user]);

        $repo->detachUser($role, $user);

        // TODO: Add notification

        return static::jsonResponseSuccess();
    }
}