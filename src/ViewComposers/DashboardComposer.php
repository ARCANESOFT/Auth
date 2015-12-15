<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\Models\Role;
use Arcanesoft\Auth\Models\User;
use Closure;
use Illuminate\Contracts\View\View;

/**
 * Class     DashboardComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class DashboardComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var \Illuminate\Contracts\View\View
     */
    protected $view;

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

    /**
     * @var int
     */
    protected $minutes = 5;

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
        $total = $this->cacheResults('auth-users-count', function() {
            return $this->users->count();
        });

        $this->view->with('authUsersTotal', $total);
    }

    protected function composeRolesTotal()
    {
        $total = $this->cacheResults('auth-roles-count', function() {
            return $this->roles->count();
        });

        $this->view->with('authRolesTotal', $total);
    }

    protected function composePermissionsTotal()
    {
        $total = $this->cacheResults('auth-permissions-count', function() {
            return $this->permissions->count();
        });

        $this->view->with('authPermissionsTotal', $total);
    }

    /**
     * Cache the results.
     *
     * @param  string    $name
     * @param  \Closure  $callback
     *
     * @return mixed
     */
    protected function cacheResults($name, Closure $callback)
    {
        return \Cache::remember($name, $this->minutes, $callback);
    }
}
