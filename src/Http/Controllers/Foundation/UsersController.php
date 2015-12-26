<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Http\Requests\Backend\Users\CreateUserRequest;
use Arcanesoft\Auth\Http\Requests\Backend\Users\UpdateUserRequest;
use Arcanesoft\Contracts\Auth\Models\Role;
use Arcanesoft\Contracts\Auth\Models\User;
use Illuminate\Support\Facades\Log;

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
    /** @var  \Arcanesoft\Contracts\Auth\Models\User  */
    protected $user;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
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

    public function trashList()
    {
        return $this->index(true);
    }

    public function create(Role $role)
    {
        $roles = $role->all();

        $title = 'Create a new user';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.create', compact('roles'));
    }

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

    public function show(User $user)
    {
        $user->load(['roles', 'roles.permissions']);

        $title = 'User details';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.show', compact('user'));
    }

    public function edit(User $user, Role $role)
    {
        $user->load(['roles', 'roles.permissions']);
        $roles = $role->all();

        $title = 'Edit a user';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.edit', compact('user', 'roles'));
    }

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
