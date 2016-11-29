<?php namespace Arcanesoft\Auth\ViewComposers;

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
        $permissions = $this->cacheResults('permissions.form', function () {
            return Permission::with(['group'])->orderBy('group_id', 'desc')->get();
        });

        $view->with('permissions', $permissions);
    }
}
