<?php namespace Arcanesoft\Auth\Http\Controllers\Foundation;

use Arcanesoft\Auth\Bases\FoundationController;
use Arcanesoft\Auth\Models\User;

/**
 * Class     UsersController
 *
 * @package  Arcanesoft\Auth\Http\Controllers\Foundation
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersController extends FoundationController
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

        $this->setCurrentPage('auth-users');
        $this->addBreadcrumbRoute('Users', 'auth::foundation.users.index');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function index()
    {
        $users = User::with('roles')->paginate(30);

        $title = 'List of users';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.list', compact('users'));
    }

    public function create()
    {
        $title = 'Create a new user';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.create');
    }

    public function store()
    {
        //
    }

    public function show(User $user)
    {
        $user->load(['roles', 'roles.permissions']);

        $title = 'User details';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $user->load(['roles', 'roles.permissions']);

        $title = 'Edit a user';
        $this->setTitle($title);
        $this->addBreadcrumb($title);

        return $this->view('foundation.users.edit', compact('user'));
    }

    public function update(User $user)
    {
        //
    }

    public function delete(User $user)
    {
        //
    }
}
