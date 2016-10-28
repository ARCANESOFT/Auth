<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Bases\ViewComposer;
use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\User;
use Illuminate\Contracts\View\View;

/**
 * Class     DashboardComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var \Arcanesoft\Auth\Models\User
     */
    protected $users;

    /**
     * @var \Arcanesoft\Auth\Models\Role
     */
    protected $roles;

    /**
     * @var \Arcanesoft\Auth\Models\Permission
     */
    protected $permissions;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * DashboardComposer constructor.
     *
     * @param User $users
     */
    public function __construct(User $users, Role $roles, Permission $permissions)
    {
        $this->users       = $users;
        $this->roles       = $roles;
        $this->permissions = $permissions;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function compose(View $view)
    {
        $this->view = $view;

        $this->composeUsersTotal();
        $this->composeRolesTotal();
        $this->composePermissionsTotal();
    }

    protected function composeUsersTotal()
    {
        $count = $this->cacheResults('auth.users.count', function() {
            return $this->users->count();
        });

        $this->view->with('authUsersCount', $count);
    }

    protected function composeRolesTotal()
    {
        $count = $this->cacheResults('auth.roles.count', function() {
            return $this->roles->count();
        });

        $this->view->with('authRolesCount', $count);
    }

    protected function composePermissionsTotal()
    {
        $count = $this->cacheResults('auth.permissions.count', function() {
            return $this->permissions->count();
        });

        $this->view->with('authPermissionsCount', $count);
    }
}
