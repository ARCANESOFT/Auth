<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Auth\Http\Requests\Admin\Roles\CreateRoleRequest;
use Arcanesoft\Auth\Http\Requests\Admin\Roles\UpdateRoleRequest;
use Arcanesoft\Auth\Policies\RolesPolicy;
use Arcanesoft\Contracts\Auth\Models\Role;
use Log;

/**
 * Class     RolesController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesController extends Controller
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
     * The Role model.
     *
     * @var \Arcanesoft\Contracts\Auth\Models\Role
     */
    protected $role;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
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
        $this->addBreadcrumbRoute('Roles', 'admin::auth.roles.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(RolesPolicy::PERMISSION_LIST);

        $roles = $this->role->with('users', 'permissions')->paginate(30);

        $this->setTitle($title = 'List of roles');
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.list', compact('roles'));
    }

    public function create()
    {
        $this->authorize(RolesPolicy::PERMISSION_CREATE);

        $this->setTitle($title = 'Create a role');
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.create');
    }

    public function store(CreateRoleRequest $request)
    {
        $this->authorize(RolesPolicy::PERMISSION_CREATE);

        $this->role->fill($request->only('name', 'slug', 'description'));
        $this->role->save();
        $this->role->permissions()->attach($request->get('permissions'));

        $message = 'The new role was successfully created !';

        Log::info($message, $this->role->toArray());
        $this->notifySuccess($message, 'Role created !');

        return redirect()
            ->route('admin::auth.roles.index')
            ->with('success', $message);
    }

    public function show(Role $role)
    {
        $this->authorize(RolesPolicy::PERMISSION_SHOW);

        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->load(['users', 'permissions', 'permissions.group']);

        $this->setTitle($title = 'Role details');
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.show', compact('role'));
    }

    public function edit(Role $role)
    {
        $this->authorize(RolesPolicy::PERMISSION_UPDATE);

        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->load(['users', 'permissions']);

        $this->setTitle($title = 'Edit Role');
        $this->addBreadcrumb($title);

        return $this->view('admin.roles.edit', compact('role'));
    }

    public function update(UpdateRoleRequest $request, Role $role)
    {
        $this->authorize(RolesPolicy::PERMISSION_UPDATE);

        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $role->fill($request->only('name', 'slug', 'description'));
        $role->save();
        $role->permissions()->sync($request->get('permissions'));

        $message = 'The role was successfully updated !';

        Log::info($message, $role->toArray());
        $this->notifySuccess($message, 'Role updated !');

        return redirect()
            ->route('admin::auth.roles.show', [$role->hashed_id])
            ->with('success', $message);
    }

    public function activate(Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $this->authorize(RolesPolicy::PERMISSION_UPDATE);

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

            return $this->jsonResponseSuccess($message);
        }
        catch(\Exception $e) {
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }

    public function delete(Role $role)
    {
        /** @var  \Arcanesoft\Auth\Models\Role  $role */
        $this->authorize(RolesPolicy::PERMISSION_DELETE);

        try {
            $role->delete();

            $message = "The role {$role->name} has been successfully deleted !";
            Log::info($message, $role->toArray());
            $this->notifySuccess($message, 'Role deleted !');

            return $this->jsonResponseSuccess($message);
        }
        catch(\Exception $e) {
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }
}
