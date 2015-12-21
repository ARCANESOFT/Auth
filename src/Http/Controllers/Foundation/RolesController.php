<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Http\Requests\Backend\Roles\CreateRoleRequest;
use Arcanesoft\Auth\Http\Requests\Backend\Roles\UpdateRoleRequest;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;
use Arcanesoft\Auth\Models\Role;
use Illuminate\Support\Facades\Log;

/**
 * Class     RolesController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setCurrentPage('auth-roles');
        $this->addBreadcrumbRoute('Roles', 'auth::foundation.roles.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $roles = Role::with('users', 'permissions')->paginate(30);

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

    public function store(CreateRoleRequest $request, Role $role)
    {
        $role->fill($request->only('name', 'slug', 'description'));
        $role->save();
        $role->permissions()->attach($request->get('permissions'));

        $message = 'The new role was successfully created !';

        Log::info($message, $role->toArray());

        return redirect()
            ->route('auth::foundation.roles.index')
            ->with('success', $message);
    }

    public function show(Role $role)
    {
        $role->load(['users', 'permissions', 'permissions.group']);

        $title = 'Role details';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $role->load(['users', 'permissions']);

        $title = 'Edit Role';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->fill($request->only('name', 'slug', 'description'));
        $role->save();
        $role->permissions()->sync($request->get('permissions'));

        $message = 'The role was successfully updated !';

        Log::info($message, $role->toArray());

        return redirect()
            ->route('auth::foundation.roles.show', [$role->hashed_id])
            ->with('success', $message);
    }

    public function delete(Role $role)
    {
        //
    }
}
