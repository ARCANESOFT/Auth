<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Metrics\Users;

use Arcanedev\LaravelMetrics\Metrics\NullablePartition;
use Arcanesoft\Auth\Repositories\UsersRepository;
use Illuminate\Http\Request;

/**
 * Class     ActivatedUsers
 *
 * @package  Arcanesoft\Auth\Metrics\Users
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ActivatedUsers extends NullablePartition
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
        return $this->count($repo->query(), 'activated_at')
                    ->labels([
                        0 => __('Deactivated'),
                        1 => __('Activated'),
                    ])
                    ->colors([
                        0 => '#6C757D',
                        1 => '#28A745',
                    ])
                    ->sort('desc');
    }
}
