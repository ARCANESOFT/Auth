<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Http\Requests\Backend\Users\CreateUserRequest;
use Arcanesoft\Auth\Http\Requests\Backend\Users\UpdateUserRequest;
use Arcanesoft\Contracts\Auth\Models\Role;
use Arcanesoft\Contracts\Auth\Models\User;
use Log;

/**
 * Class     UsersController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Adding the authorization checks
 */
class UsersController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The user model.
     *
     * @var  \Arcanesoft\Contracts\Auth\Models\User
     */
    protected $user;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
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
        $this->addBreadcrumbRoute('Users', 'auth::foundation.users.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
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
        $users = $this->user->with('roles');

        $users = $trashed
            ? $users->onlyTrashed()->paginate(30)
            : $users->paginate(30);

        $title = 'List of users' . ($trashed ? ' - Trashed' : '');
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.list', compact('trashed', 'users'));
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
        $users = $role->users()->with('roles')->paginate(30);

        $title = "List of users - {$role->name} Role" . ($trashed ? ' - Trashed' : '');
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.list', compact('trashed', 'users'));
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
        $roles = $role->all();

        $title = 'Create a new user';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.create', compact('roles'));
    }

    /**
     * Store the new user.
     *
     * @param  \Arcanesoft\Auth\Http\Requests\Backend\Users\CreateUserRequest  $request
     * @param  \Arcanesoft\Contracts\Auth\Models\User                          $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request, User $user)
    {
        $data = $request->only([
            'username', 'email', 'first_name', 'last_name', 'password'
        ]);
        $user->fill($data);
        $user->is_active = true;
        $user->save();
        $user->roles()->sync($request->get('roles'));

        $message = "The user {$user->username} was created successfully !";
        Log::info($message, $user->toArray());
        $this->notifySuccess($message, 'User created !');

        return redirect()->route('auth::foundation.users.index');
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
        $user->load(['roles', 'roles.permissions']);

        $title = 'User details';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.show', compact('user'));
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
        $user->load(['roles', 'roles.permissions']);
        $roles = $role->all();

        $title = 'Edit a user';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the user.
     *
     * @param  \Arcanesoft\Auth\Http\Requests\Backend\Users\UpdateUserRequest  $request
     * @param  \Arcanesoft\Contracts\Auth\Models\User                          $user
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $inputs = ['username', 'email', 'first_name', 'last_name'];

        if ($request->has('password')) {
            $inputs[] = 'password';
        }

        $user->update($request->only($inputs));
        $user->roles()->sync($request->get('roles'));

        $message = "The user {$user->username} was updated successfully !";
        Log::info($message, $user->toArray());
        $this->notifySuccess($message, 'User Updated !');

        return redirect()->route('auth::foundation.users.show', [
            $user->hashed_id
        ]);
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
        self::onlyAjax();

        try {
            if ($user->isActive()) {
                $title   = 'User disabled !';
                $message = "The user {$user->username} has been successfully disabled !";
                $user->deactivate();
            }
            else {
                $title   = 'User activated !';
                $message = "The user {$user->username} has been successfully activated !";
                $user->activate();
            }

            Log::info($message, $user->toArray());
            $this->notifySuccess($message, $title);

            $ajax = [
                'status'  => 'success',
                'message' => $message,
            ];
        }
        catch (\Exception $e) {
            $ajax = [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($ajax);
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
        self::onlyAjax();

        try {
            $user->restore();

            $message = "The user {$user->username} has been successfully restored !";
            Log::info($message, $user->toArray());
            $this->notifySuccess($message, 'User restored !');

            $ajax = [
                'status'  => 'success',
                'message' => $message,
            ];
        }
        catch (\Exception $e) {
            $ajax = [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($ajax);
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
        self::onlyAjax();

        try {
            if ($user->trashed()) {
                $user->forceDelete();
                $message = "The user {$user->username} has been successfully deleted !";
                Log::info($message, $user->toArray());
            }
            else {
                $user->delete();
                $message = "The user {$user->username} was placed in trashed users !";
            }

            $this->notifySuccess($message, 'User deleted !');

            $ajax = [
                'status'  => 'success',
                'message' => $message,
            ];
        }
        catch(\Exception $e) {
            $ajax = [
                'status'  => 'error',
                'message' => $e->getMessage(),
            ];
        }

        return response()->json($ajax);
    }
}
