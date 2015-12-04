<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Models\Role;

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
        $this->addBreadcrumb($title);

        return $this->view('foundation.roles.list', compact('roles'));
    }

    public function create()
    {
        return $this->view('foundation.roles.create');
    }

    public function store()
    {
        //
    }

    public function show(Role $role)
    {
        $role->load(['users', 'permissions']);

        return $this->view('foundation.roles.show');
    }

    public function edit(Role $role)
    {
        $role->load(['users', 'permissions']);

        return $this->view('foundation.roles.show');
    }

    public function update(Role $role)
    {
        //
    }

    public function delete(Role $role)
    {
        //
    }
}
