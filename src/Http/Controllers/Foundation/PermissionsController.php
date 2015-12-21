<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\PermissionsGroup;

/**
 * Class     PermissionsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsController extends FoundationController
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var int */
    protected $perPage = 30;

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

        $this->setCurrentPage('auth-permissions');
        $this->addBreadcrumbRoute('Permissions', 'auth::foundation.permissions.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index(Permission $permission)
    {
        $permissions = $permission->with('group', 'roles')
            ->orderBy('group_id')
            ->paginate($this->perPage);

        $title = 'List of permissions';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.permissions.list', compact('permissions'));
    }

    public function group(Permission $permission, PermissionsGroup $group)
    {
        $groupId = $group->id ? $group->id : 0;

        $permissions = $permission->where('group_id', $groupId)
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
        $permission->load(['roles', 'roles.users']);

        $title = 'Permission details';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.permissions.show', compact('permission'));
    }
}
