<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanedev\LaravelAuth\Services\UserImpersonator;
use Arcanesoft\Auth\Http\Requests\Admin\Users\CreateUserRequest;
use Arcanesoft\Auth\Http\Requests\Admin\Users\UpdateUserRequest;
use Arcanesoft\Auth\Policies\UsersPolicy;
use Arcanesoft\Contracts\Auth\Models\Role;
use Arcanesoft\Contracts\Auth\Models\User;
use Log;

/**
 * Class     UsersController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersController extends Controller
{
    /* -----------------------------------------------------------------
     |  Traits
     | -----------------------------------------------------------------
     */

    use JsonResponses;

    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The user model.
     *
     * @var  \Arcanesoft\Contracts\Auth\Models\User
     */
    protected $user;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */

    /**
     * Instantiate the controller.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     */
    public function __construct(User $user)
    {
        parent::__construct();

        $this->user = $user;

        $this->setCurrentPage('auth-users');
        $this->addBreadcrumbRoute(trans('auth::users.titles.users'), 'admin::auth.users.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * List the users.
     *
     * @param  bool  $trashed
     *
     * @return \Illuminate\View\View
     */
    public function index($trashed = false)
    {
        $this->authorize(UsersPolicy::PERMISSION_LIST);

        $users = $this->user->with('roles');

        $users = $trashed ? $users->onlyTrashed()->paginate(30) : $users->paginate(30);

        $title = trans('auth::users.titles.users-list').($trashed ? ' - '.trans('core::generals.trashed') : '');
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('admin.users.list', compact('trashed', 'users'));
    }

    /**
     * List the trashed users.
     *
     * @return \Illuminate\View\View
     */
    public function trashList()
    {
        return $this->index(true);
    }

    /**
     * List the users by a role.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\Role  $role
     * @param  bool                                    $trashed
     *
     * @return \Illuminate\View\View
     */
    public function listByRole(Role $role, $trashed = false)
    {
        $this->authorize(UsersPolicy::PERMISSION_LIST);

        $users = $role->users()->with('roles')->paginate(30);

        $title = trans('auth::users.titles.users-list')." - {$role->name} Role". ($trashed ? ' - '.trans('core::generals.trashed') : '');
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('admin.users.list', compact('trashed', 'users'));
    }

    /**
     * Show the create a new user form.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\Role  $role
     *
     * @return \Illuminate\View\View
     */
    public function create(Role $role)
    {
        $this->authorize(UsersPolicy::PERMISSION_CREATE);

        $roles = $role->all();

        $this->setTitle($title = trans('auth::users.titles.create-user'));
        $this->addBreadcrumb($title);

        return $this->view('admin.users.create', compact('roles'));
    }

    /**
     * Store the new user.
     *
     * @param  \Arcanesoft\Auth\Http\Requests\Admin\Users\CreateUserRequest  $request
     * @param  \Arcanesoft\Contracts\Auth\Models\User                        $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request, User $user)
    {
        $this->authorize(UsersPolicy::PERMISSION_CREATE);

        $user->fill(
            $request->only(['username', 'email', 'first_name', 'last_name', 'password'])
        );
        $user->is_active = true;
        $user->save();
        $user->roles()->sync($request->get('roles'));

        $this->transNotification('created', ['name' => $user->full_name], $user->toArray());

        return redirect()->route('admin::auth.users.index');
    }

    /**
     * Show the user's details.
     *
     * @param \Arcanesoft\Contracts\Auth\Models\User $user
     *
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $this->authorize(UsersPolicy::PERMISSION_SHOW);

        $user->load(['roles', 'roles.permissions']);

        $this->setTitle($title = trans('auth::users.titles.user-details'));
        $this->addBreadcrumb($title);

        return $this->view('admin.users.show', compact('user'));
    }

    /**
     * Show the edit the user form.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     * @param  \Arcanesoft\Contracts\Auth\Models\Role  $role
     *
     * @return \Illuminate\View\View
     */
    public function edit(User $user, Role $role)
    {
        $this->authorize(UsersPolicy::PERMISSION_UPDATE);

        $user->load(['roles', 'roles.permissions']);
        $roles = $role->all();

        $this->setTitle($title = trans('auth::users.titles.edit-user'));
        $this->addBreadcrumb($title);

        return $this->view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the user.
     *
     * @param  \Arcanesoft\Auth\Http\Requests\Admin\Users\UpdateUserRequest  $request
     * @param  \Arcanesoft\Contracts\Auth\Models\User                        $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize(UsersPolicy::PERMISSION_UPDATE);

        $user->update($request->intersect(['username', 'email', 'password', 'first_name', 'last_name']));
        $user->roles()->sync($request->get('roles'));

        $this->transNotification('updated', ['name' => $user->full_name], $user->toArray());

        return redirect()->route('admin::auth.users.show', [$user->hashed_id]);
    }

    /**
     * Activate/Disable a user.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function activate(User $user)
    {
        $this->authorize(UsersPolicy::PERMISSION_UPDATE);

        try {
            ($active = $user->isActive()) ? $user->deactivate() : $user->activate();

            $message = $this->transNotification(
                $active ? 'disabled' : 'enabled',
                ['name' => $user->full_name],
                $user->toArray()
            );

            return $this->jsonResponseSuccess(compact('message'));
        }
        catch (\Exception $e) {
            return $this->jsonResponseError(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Restore the trashed user.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function restore(User $user)
    {
        $this->authorize(UsersPolicy::PERMISSION_UPDATE);

        try {
            $user->restore();

            $message = $this->transNotification('restored', ['name' => $user->full_name], $user->toArray());

            return $this->jsonResponseSuccess(compact('message'));
        }
        catch (\Exception $e) {
            return $this->jsonResponseError(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Delete a user.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(User $user)
    {
        $this->authorize(UsersPolicy::PERMISSION_DELETE);

        try {
            ($trashed = $user->trashed()) ? $user->forceDelete() : $user->delete();

            $message = $this->transNotification(
                $trashed ? 'deleted' : 'trashed',
                ['name' => $user->full_name],
                $user->toArray()
            );

            return $this->jsonResponseSuccess(compact('message'));
        }
        catch(\Exception $e) {
            return $this->jsonResponseError(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Impersonate a user.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\User  $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function impersonate(User $user)
    {
        if ( ! UserImpersonator::start($user)) {
            $this->notifyDanger(
                trans('auth::users.messages.impersonation-failed.message'),
                trans('auth::users.messages.impersonation-failed.title')
            );

            return redirect()->back();
        }

        return redirect()->to('/');
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Notify with translation.
     *
     * @param  string  $action
     * @param  array   $replace
     * @param  array   $context
     *
     * @return string
     */
    protected function transNotification($action, array $replace = [], array $context = [])
    {
        $title   = trans("auth::users.messages.{$action}.title");
        $message = trans("auth::users.messages.{$action}.message", $replace);

        Log::info($message, $context);
        $this->notifySuccess($message, $title);

        return $message;
    }
}
