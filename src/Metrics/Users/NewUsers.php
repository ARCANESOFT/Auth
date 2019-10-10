<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Metrics\Users;

use Arcanedev\LaravelMetrics\Metrics\RangedValue;
use Arcanesoft\Auth\Repositories\UsersRepository;
use Illuminate\Http\Request;

/**
 * Class     NewUsers
 *
 * @package  Arcanesoft\Auth\Metrics\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class NewUsers extends RangedValue
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request                       $request
     * @param  \Arcanesoft\Auth\Repositories\UsersRepository  $repo
     *
     * @return \Arcanedev\LaravelMetrics\Results\Result|mixed
     */
    public function calculate(Request $request, UsersRepository $repo)
    {
        return $this->count($repo->query());
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array
    {
        return [
            1   => __('Today'),
            7   => __('7 Days'),
            30  => __('30 Days'),
            60  => __('60 Days'),
            365 => __('365 Days'),
        ];
    }
}
