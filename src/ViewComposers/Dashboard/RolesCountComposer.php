<?php namespace Arcanesoft\Auth\ViewComposers\Dashboard;

use Arcanesoft\Auth\ViewComposers\ViewComposer;
use Illuminate\Contracts\View\View;

/**
 * Class     RolesCountComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RolesCountComposer extends ViewComposer
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */
    const VIEW = 'auth::admin._composers.dashboard.roles-count-box';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Compose the view.
     *
     * @param  \Illuminate\Contracts\View\View  $view
     */
    public function compose(View $view)
    {
        $view->with('rolesCount', $this->getCachedRoles()->count());
    }
}

