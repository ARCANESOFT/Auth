<?php namespace Arcanesoft\Auth\ViewComposers\Dashboard;

use Arcanesoft\Auth\Models\Permission;
use Arcanesoft\Auth\ViewComposers\ViewComposer;
use Illuminate\Contracts\View\View;

class PermissionsCountComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'auth::foundation._composers.dashboard.permissions-count-box';

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
        $view->with('permissionsCount', $this->getCachedPermissions()->count());
    }
}
