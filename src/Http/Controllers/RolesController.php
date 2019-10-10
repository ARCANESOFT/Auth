<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Http\Controllers;

use Arcanesoft\Auth\Http\Requests\Roles\{CreateRoleRequest, UpdateRoleRequest};
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Policies\RolesPolicy;
use Arcanesoft\Auth\Repositories\{PermissionsRepository, RolesRepository};
use Arcanesoft\Foundation\Concerns\HasNotifications;

/**
 * Class     RolesController
 *
 * @package  Arcanesoft\Auth\Http\Controllers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesController extends Controller
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

        $this->setCurrentSidebarItem('auth::authorization.roles');
        $this->addBreadcrumbRoute(__('Roles'), 'admin::auth.roles.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    public function index()
    {
        $this->authorize(RolesPolicy::ability('index'));

        return $this->view('roles.index');
    }

    public function metrics()
    {
        $this->authorize(RolesPolicy::ability('metrics'));

        $this->addBreadcrumbRoute(__('Metrics'), 'admin::auth.users.metrics');

        $this->selectMetrics('arcanesoft.auth.metrics.roles');

        return $this->view('roles.metrics');
    }

    public function create(PermissionsRepository $permissionsRepo)
    {
        $this->authorize(RolesPolicy::ability('create'));

        $this->addBreadcrumb(__('Create Role'));

        $permissions = $permissionsRepo->with(['group'])->get();

        return $this->view('roles.create', compact('permissions'));
    }

    public function store(CreateRoleRequest $request, RolesRepository $rolesRepo)
    {
        $this->authorize(RolesPolicy::ability('create'));

        $data = $request->getValidatedData();
        $role = $rolesRepo->create($data);

        $rolesRepo->syncPermissionsByUuids($role, $data['permissions'] ?: []);

        return redirect()->route('admin::auth.roles.show', [$role]);
    }

    public function show(Role $role)
    {
        $this->authorize(RolesPolicy::ability('show'), [$role]);

        $role->load(['users', 'permissions.group']);

        $this->addBreadcrumbRoute($role->name, 'admin::auth.roles.show', [$role]);

        return $this->view('roles.show', compact('role'));
    }

    public function edit(Role $role, PermissionsRepository $permissionsRepo)
    {
        $this->authorize(RolesPolicy::ability('update'));

        $this->addBreadcrumb(__('Edit Role'));

        $role->load(['permissions']);
        $permissions = $permissionsRepo->with(['group'])->get();

        return $this->view('roles.edit', compact('role', 'permissions'));
    }

    public function update(Role $role, UpdateRoleRequest $request, RolesRepository $rolesRepo)
    {
        $this->authorize(RolesPolicy::ability('update'));

        $data = $request->getValidatedData();
        $rolesRepo->update($role, $data);

        if (empty($permissions = $data['permissions'] ?: []))
            $rolesRepo->detachAllPermissions($role);
        else
            $rolesRepo->syncPermissionsByUuids($role, $permissions);

        return redirect()->route('admin::auth.roles.show', [$role]);
    }

    public function activate(Role $role, RolesRepository $rolesRepo)
    {
        $this->authorize(RolesPolicy::ability('activate'), [$role]);

        $rolesRepo->toggleActive($role);

        $this->notifySuccess(
            __($role->isActive() ? 'Role Activated' : 'Role Deactivated'),
            __($role->isActive() ? 'The role has been successfully activated!' : 'The role has been successfully deactivated!')
        );

        return $this->jsonResponseSuccess();
    }

    public function delete(Role $role, RolesRepository $rolesRepo)
    {
        $this->authorize(RolesPolicy::ability('delete'), [$role]);

        $rolesRepo->delete($role);

        return $this->jsonResponseSuccess();
    }
}
