<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;

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
        //
    }

    public function create()
    {
        //
    }

    public function store()
    {
        //
    }

    public function show($roleId)
    {
        //
    }

    public function edit($roleId)
    {
        //
    }

    public function update($roleId)
    {
        //
    }

    public function delete($roleId)
    {
        //
    }
}
