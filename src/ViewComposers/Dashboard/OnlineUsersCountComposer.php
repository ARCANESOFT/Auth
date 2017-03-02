<?php namespace Arcanesoft\Auth\ViewComposers\Dashboard;

use Arcanesoft\Auth\Models\User;
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
    /* -----------------------------------------------------------------
     |  Constants
     | -----------------------------------------------------------------
     */
    const VIEW = 'auth::admin._composers.dashboard.online-users-count-box';

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
        $view->with('onlineUsersCount', $this->getOnlineUsers()->count());
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */
    /**
     * Get the online users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getOnlineUsers()
    {
        $date = Carbon::now()->subMinutes(
            config('arcanesoft.auth.track-activity.minutes', 5)
        );

        return $this->getCachedUsers()->filter(function (User $user) use ($date) {
            return ! is_null($user->last_activity) && $user->last_activity->gte($date);
        });
    }
}
