<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Policies\PermissionsPolicy;
use Arcanesoft\Contracts\Auth\Models\Permission;
use Arcanesoft\Contracts\Auth\Models\PermissionsGroup;
use Arcanesoft\Contracts\Auth\Models\Role;
use Log;

/**
 * Class     PermissionsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsController extends Controller
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var  \Arcanesoft\Contracts\Auth\Models\Permission  */
    protected $permission;

    /** @var int */
    protected $perPage = 30;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
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
        $this->addBreadcrumbRoute('Permissions', 'auth::foundation.permissions.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $this->authorize(PermissionsPolicy::PERMISSION_LIST);

        $permissions = $this->permission->with('group', 'roles')
            ->orderBy('group_id')
            ->paginate($this->perPage);

        $title = 'List of permissions';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.permissions.list', compact('permissions'));
    }

    public function group(PermissionsGroup $group)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_LIST);

        $groupId = $group->id ? $group->id : 0;

        $permissions = $this->permission->where('group_id', $groupId)
            ->with('group', 'roles')
            ->paginate($this->perPage);

        $this->addBreadcrumbRoute('List of permissions', 'auth::foundation.permissions.index');

        $groupName = $groupId == 0 ? 'Custom' : $group->name;
        $title     = "List of permissions - $groupName";
        $this->setTitle($title);
        $this->addBreadcrumb($groupName);

        return $this->view('foundation.permissions.list', compact('permissions'));
    }

    public function show(Permission $permission)
    {
        $this->authorize(PermissionsPolicy::PERMISSION_SHOW);

        $permission->load(['roles', 'roles.users']);

        $title = 'Permission details';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.permissions.show', compact('permission'));
    }

    public function detachRole(Permission $permission, Role $role)
    {
        self::onlyAjax();
        $this->authorize(PermissionsPolicy::PERMISSION_UPDATE);

        try {
            $permission->detachRole($role, false);

            $title   = 'Role detached !';
            $message = "The role {$role->name} has been successfully detached from {$permission->name} !";

            Log::info($message, compact('permission', 'role'));
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
}
