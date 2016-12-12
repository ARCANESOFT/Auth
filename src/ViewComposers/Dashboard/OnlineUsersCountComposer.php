<?php namespace Arcanesoft\Auth\ViewComposers\Dashboard;

use Arcanesoft\Auth\ViewComposers\ViewComposer;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

/**
 * Class     OnlineUsersCountComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class OnlineUsersCountComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'auth::foundation._composers.dashboard.online-users-count-box';

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
        $date = Carbon::now()->subMinutes(
            config('arcanesoft.auth.track-activity.minutes', 5)
        );

        $users = $this->getCachedUsers()->filter(function ($user) use ($date) {
            /** @var  \Arcanesoft\Auth\Models\User  $user */
            return ! is_null($user->last_activity) && $user->last_activity->gte($date);
        });

        $view->with('onlineUsersCount', $users->count());
    }
}
