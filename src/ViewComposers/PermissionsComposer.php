<?php namespace Arcanesoft\Auth\ViewComposers;

use Arcanesoft\Auth\Bases\ViewComposer;
use Arcanesoft\Auth\Models\Permission;
use Illuminate\Contracts\View\View;

/**
 * Class     PermissionsComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PermissionsComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @var \Arcanesoft\Auth\Models\Permission
     */
    protected $permissions;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * PermissionsComposer constructor.
     *
     * @param Permission $permissions
     */
    public function __construct(Permission $permissions)
    {
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
    public function composeRolePermissions(View $view)
    {
        $permissions = $this->cacheResults('auth-permissions-form', function () {
            return $this->permissions
                ->with('group')
                ->orderBy('group_id', 'desc')
                ->get();
        });

        $view->with('permissions', $permissions);
    }
}
