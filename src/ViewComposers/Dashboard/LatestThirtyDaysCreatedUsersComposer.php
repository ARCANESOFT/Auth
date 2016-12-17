<?php namespace Arcanesoft\Auth\ViewComposers\Dashboard;

use Arcanesoft\Auth\Models\User;
use Arcanesoft\Auth\ViewComposers\ViewComposer;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

/**
 * Class     LatestThirtyDaysCreatedUsersComposer
 *
 * @package  Arcanesoft\Auth\ViewComposers\Dashboard
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class LatestThirtyDaysCreatedUsersComposer extends ViewComposer
{
    /* ------------------------------------------------------------------------------------------------
     |  Constants
     | ------------------------------------------------------------------------------------------------
     */
    const VIEW = 'auth::admin._composers.dashboard.lastest-30-days-users-chart';

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Date format.
     *
     * @var string
     */
    protected $format = 'M-d';

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
        $users = $this->prepareUsersData(
            $start = Carbon::now()->subMonth(1)->setTime(0, 0),
            $end = Carbon::now()->setTime(23, 59, 59)
        );

        $view->with(
            'latestUsersByThirtyDays',
            $this->getDatesRange($start, $end)->transform(function ($date) use ($users) {
                return $users->get($date, new Collection)->count();
            })
        );
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Prepare the users data.
     *
     * @param  \Carbon\Carbon  $start
     * @param  \Carbon\Carbon  $end
     *
     * @return \Illuminate\Support\Collection
     */
    public function prepareUsersData(Carbon $start, Carbon $end)
    {
        return $this->getCachedUsers()
            ->filter(function (User $user) use ($start, $end){
                return $user->created_at->between($start, $end);
            })
            ->groupBy(function (User $user) {
                return $user->created_at->format($this->format);
            })
            ->toBase();
    }

    /**
     * Get the dates ranges.
     *
     * @param  \Carbon\Carbon  $start
     * @param  \Carbon\Carbon  $end
     *
     * @return \Illuminate\Support\Collection
     */
    private function getDatesRange(Carbon $start, Carbon $end)
    {
        $range = new Collection();

        foreach (new DatePeriod($start, DateInterval::createFromDateString('1 day'), $end) as $period) {
            $range->put($date = $period->format($this->format), $date);
        }

        return $range;
    }
}
