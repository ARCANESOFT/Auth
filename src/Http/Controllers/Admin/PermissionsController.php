<?php namespace Arcanesoft\Auth\Http\Controllers\Admin;

use Arcanedev\LaravelApiHelper\Traits\JsonResponses;
use Arcanesoft\Auth\Policies\PermissionsPolicy;
use Arcanesoft\Contracts\Auth\Models\Permission;
use Arcanesoft\Contracts\Auth\Models\PermissionsGroup;
use Arcanesoft\Contracts\Auth\Models\Role;
use Log;

/**
 * Class     PermissionsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Admin
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsController extends Controller
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
    /** @var  \Arcanesoft\Contracts\Auth\Models\Permission  */
    protected $permission;

    /** @var int */
    protected $perPage = 30;

    /* -----------------------------------------------------------------
     |  Constructor
     | -----------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     *
     * @param  \Arcanesoft\Contracts\Auth\Models\Permission  $permission
     */
    public function __construct(Permission $permission)
    {
        parent::__construct();

        $this->permission = $permission;

        $this->setCurrentPage('auth-permissions');
        $this->addBreadcrumbRoute('Permissions', 'admin::auth.permissions.index');
    }

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(PermissionsPolicy::PERMISSION_LIST);

        $permissions = $this->permission->with('group', 'roles')
            ->orderBy('group_id')
            ->paginate($this->perPage);

        $this->setTitle($title = 'List of permissions');
        $this->addBreadcrumb($title);

        return $this->view('admin.permissions.list', compact('permissions'));
    }

    public function group(PermissionsGroup $group)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_LIST);

        $groupId = $group->id ? $group->id : 0;

        $permissions = $this->permission->where('group_id', $groupId)
            ->with('group', 'roles')
            ->paginate($this->perPage);

        $groupName = $groupId == 0 ? 'Custom' : $group->name;

        $this->setTitle($title = "List of permissions - $groupName");
        $this->addBreadcrumbRoute('List of permissions', 'admin::auth.permissions.index');
        $this->addBreadcrumb($groupName);

        return $this->view('admin.permissions.list', compact('permissions'));
    }

    public function show(Permission $permission)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_SHOW);

        $permission->load(['roles', 'roles.users']);

        $this->setTitle($title = 'Permission details');
        $this->addBreadcrumb($title);

        return $this->view('admin.permissions.show', compact('permission'));
    }

    public function detachRole(Permission $permission, Role $role)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_UPDATE);

        try {
            $permission->detachRole($role, false);

            $title   = 'Role detached !';
            $message = "The role {$role->name} has been successfully detached from {$permission->name} !";

            Log::info($message, compact('permission', 'role'));
            $this->notifySuccess($message, $title);

            return $this->jsonResponseSuccess($message);
        }
        catch(\Exception $e) {
            return $this->jsonResponseError($e->getMessage(), 500);
        }
    }
}
