<?php namespace Arcanesoft\Auth\ViewComposers\Dashboard;

use Arcanesoft\Auth\ViewComposers\ViewComposer;
use Illuminate\Contracts\View\View;

/**
 * Class     UsersCountComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class UsersCountComposer extends ViewComposer
{
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */
    const VIEW = 'auth::admin._composers.dashboard.users-count-box';

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
        $view->with('usersCount', $this->getCachedUsers()->count());
    }
}
