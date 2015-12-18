<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Models\Permission;

/**
 * Class     PermissionsController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsController extends FoundationController
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

        $this->setCurrentPage('auth-permissions');
        $this->addBreadcrumbRoute('Permissions', 'auth::foundation.permissions.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $permissions = Permission::with('roles')->paginate(30);

        $title = 'List of permissions';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

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
