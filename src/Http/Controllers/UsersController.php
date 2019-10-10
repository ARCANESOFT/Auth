<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers;

use Arcanedev\LaravelImpersonator\Contracts\Impersonator;
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Http\Requests\Users\{CreateUserRequest, UpdateUserRequest};
use Arcanesoft\Auth\Models\User;
use Arcanesoft\Auth\Policies\UsersPolicy;
use Illuminate\Http\Request;
use Arcanesoft\Auth\Repositories\{RolesRepository, UsersRepository};
use Arcanesoft\Foundation\Concerns\HasNotifications;

/**
 * Class     UsersController
 *
 * @package  Arcanesoft\Auth\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use HasNotifications;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    public function __construct()
    {
        parent::__construct();

        $this->setCurrentSidebarItem('auth::authorization.users');
        $this->addBreadcrumbRoute(__('Users'), 'admin::auth.users.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * List all the users.
     *
     * @param  bool  $trash
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index($trash = false)
    {
        $this->authorize(UsersPolicy::ability('index'));

        return $this->view('users.index', compact('trash'));
    }

    /**
     * List all the deleted users.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function trash()
    {
        $this->authorize(UsersPolicy::ability('index'));

        return $this->index(true);
    }

    /**
     * Show the metrics.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function metrics()
    {
        $this->authorize(UsersPolicy::ability('metrics'));

        $this->addBreadcrumbRoute(__('Metrics'), 'admin::auth.users.metrics');

        $this->selectMetrics('arcanesoft.auth.metrics.users');

        return $this->view('users.metrics');
    }

    /**
     * Create a new user.
     *
     * @param  \Arcanesoft\Auth\Repositories\RolesRepository  $rolesRepo
     * @param  \Illuminate\Http\Request                       $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(RolesRepository $rolesRepo, Request $request)
    {
        $this->authorize(UsersPolicy::ability('create'));

        $roles = $rolesRepo->getFilteredByAuthenticatedUser($request->user());

        $this->addBreadcrumb(__('New User'));

        return $this->view('users.create', compact('roles'));
    }

    /**
     * Persit the new user.
     *
     * @param  \Arcanesoft\Auth\Http\Requests\Users\CreateUserRequest  $request
     * @param  \Arcanesoft\Auth\Repositories\UsersRepository           $usersRepo
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request, UsersRepository $usersRepo)
    {
        $this->authorize(UsersPolicy::ability('create'));

        $data = $request->getValidatedData();
        $user = $usersRepo->create($data);
        $usersRepo->syncRolesByUuids($user, $data['roles'] ?: []);

        $this->notifySuccess(
            __('User Created'),
            __('A new user has been successfully created!')
        );

        return redirect()->route('admin::auth.users.show', [$user]);
    }

    /**
     * Show the user's details.
     *
     * @param  \Arcanesoft\Auth\Models\User  $user
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function show(User $user)
    {
        $this->authorize(UsersPolicy::ability('show'), [$user]);

        $this->addBreadcrumbRoute(__("User's details"), 'admin::auth.users.show', [$user]);

        return $this->view('users.show', compact('user'));
    }

    /**
     * Edit the user.
     *
     * @param  \Arcanesoft\Auth\Models\User                   $user
     * @param  \Arcanesoft\Auth\Repositories\RolesRepository  $rolesRepo
     * @param  \Illuminate\Http\Request                       $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user, RolesRepository $rolesRepo, Request $request)
    {
        $this->authorize(UsersPolicy::ability('update'), [$user]);

        $roles = $rolesRepo->getFilteredByAuthenticatedUser($request->user());

        $this->addBreadcrumbRoute(__('Edit User'), 'admin::auth.users.edit', [$user]);

        return $this->view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the user.
     *
     * @param  \Arcanesoft\Auth\Models\User                            $user
     * @param  \Arcanesoft\Auth\Http\Requests\Users\UpdateUserRequest  $request
     * @param  \Arcanesoft\Auth\Repositories\UsersRepository           $usersRepo
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, UpdateUserRequest $request, UsersRepository $usersRepo)
    {
        $this->authorize(UsersPolicy::ability('update'), [$user]);

        $data = $request->getValidatedData();
        $user = $usersRepo->update($user, $data);
        $usersRepo->syncRolesByUuids($user, $data['roles'] ?: []);

        $this->notifySuccess(
            __('User Updated'),
            __('The user has been successfully updated!')
        );

        return redirect()->route('admin::auth.users.show', [$user]);
    }

    /**
     * Activate/Deactivate the user.
     *
     * @param  \Arcanesoft\Auth\Models\User                   $user
     * @param  \Arcanesoft\Auth\Repositories\UsersRepository  $usersRepo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(User $user, UsersRepository $usersRepo)
    {
        $this->authorize(UsersPolicy::ability('activate'), [$user]);

        $usersRepo->toggleActive($user);

        $this->notifySuccess(
            __($user->isActive() ? 'User Activated' : 'User Deactivated'),
            __($user->isActive() ? 'The user has been successfully activated!' : 'The user has been successfully deactivated!')
        );

        return static::jsonResponseSuccess();
    }

    /**
     * Delete a user.
     *
     * @param  \Arcanesoft\Auth\Models\User                   $user
     * @param  \Arcanesoft\Auth\Repositories\UsersRepository  $usersRepo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(User $user, UsersRepository $usersRepo)
    {
        $this->authorize(UsersPolicy::ability($user->trashed() ? 'force-delete' : 'delete'), [$user]);

        $usersRepo->delete($user);

        $this->notifySuccess(
            __('User Deleted'),
            __('The user has been successfully deleted!')
        );

        return static::jsonResponseSuccess();
    }

    /**
     * Restore a deleted user.
     *
     * @param  \Arcanesoft\Auth\Models\User                   $user
     * @param  \Arcanesoft\Auth\Repositories\UsersRepository  $usersRepo
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(User $user, UsersRepository $usersRepo)
    {
        $this->authorize(UsersPolicy::ability('restore'), [$user]);

        $usersRepo->restore($user);

        $this->notifySuccess(
            __('User Restored'),
            __('The user has been successfully restored!')
        );

        return static::jsonResponseSuccess();
    }

    /**
     * Impersonate a user.
     *
     * @param  \Arcanesoft\Auth\Models\User                           $user
     * @param  \Arcanedev\LaravelImpersonator\Contracts\Impersonator  $impersonator
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function impersonate(User $user, Impersonator $impersonator)
    {
        $this->authorize(UsersPolicy::ability('impersonate'), [$user]);

        /**
         * @var  \Arcanedev\LaravelImpersonator\Contracts\Impersonatable  $authUser
         * @var  \Arcanedev\LaravelImpersonator\Contracts\Impersonatable  $user
         */
        $authUser = auth()->user();

        if ($impersonator->start($authUser, $user))
            return redirect()->route('public::index');

        $this->notifyError(
            __('Impersonation Not Allowed'),
            __('You\'re not allowed to impersonate this user')
        );

        return redirect()->back();
    }
}
