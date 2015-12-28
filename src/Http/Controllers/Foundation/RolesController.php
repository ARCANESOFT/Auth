<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Http\Requests\Backend\Roles\CreateRoleRequest;
use Arcanesoft\Auth\Http\Requests\Backend\Roles\UpdateRoleRequest;
use Arcanesoft\Contracts\Auth\Models\Role;
use Illuminate\Support\Facades\Log;

/**
 * Class     RolesController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 *
 * @todo: Adding the authorization checks
 */
class RolesController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The Role model.
     *
     * @var \Arcanesoft\Contracts\Auth\Models\Role|\Arcanesoft\Auth\Models\Role
     */
    protected $role;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\Role  $role
     */
    public function __construct(Role $role)
    {
        parent::__construct();

        $this->role = $role;

        $this->setCurrentPage('auth-roles');
        $this->addBreadcrumbRoute('Roles', 'auth::foundation.roles.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $roles = $this->role->with('users', 'permissions')->paginate(30);

        $title = 'List of roles';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.roles.list', compact('roles'));
    }

    public function create()
    {
        $title = 'Create a role';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.roles.create');
    }

    public function store(CreateRoleRequest $request)
    {
        $this->role->fill($request->only('name', 'slug', 'description'));
        $this->role->save();
        $this->role->permissions()->attach($request->get('permissions'));

        $message = 'The new role was successfully created !';

        Log::info($message, $this->role->toArray());
        $this->notifySuccess($message, 'Role created !');

        return redirect()
            ->route('auth::foundation.roles.index')
            ->with('success', $message);
    }

    public function show(Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->load(['users', 'permissions', 'permissions.group']);

        $title = 'Role details';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->load(['users', 'permissions']);

        $title = 'Edit Role';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->fill($request->only('name', 'slug', 'description'));
        $role->save();
        $role->permissions()->sync($request->get('permissions'));

        $message = 'The role was successfully updated !';

        Log::info($message, $role->toArray());
        $this->notifySuccess($message, 'Role updated !');

        return redirect()
            ->route('auth::foundation.roles.show', [$role->hashed_id])
            ->with('success', $message);
    }

    public function activate(Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        self::onlyAjax();

        try {
            if ($role->isActive()) {
                $role->deactivate();
                $title   = 'Role disabled !';
                $message = "The role {$role->name} has been successfully disabled !";
            }
            else {
                $role->activate();
                $title   = 'Role activated !';
                $message = "The role {$role->name} has been successfully activated !";
            }


            Log::info($message, $role->toArray());
            $this->notifySuccess($message, $title);

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

    public function delete(Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        self::onlyAjax();

        try {
            $role->delete();

            $message = "The role {$role->name} has been successfully deleted !";
            Log::info($message, $role->toArray());
            $this->notifySuccess($message, 'Role deleted !');

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
