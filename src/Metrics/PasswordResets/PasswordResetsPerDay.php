<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Metrics\PasswordResets;

use Arcanedev\LaravelMetrics\Metrics\Trend;
use Arcanesoft\Auth\Repositories\PasswordResetsRepository;
use Illuminate\Http\Request;

/**
 * Class     PasswordResetsPerDay
 *
 * @package  Arcanesoft\Auth\Metrics\PasswordResets
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PasswordResetsPerDay extends Trend
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Calculate the value of the metric.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function calculate(Request $request, PasswordResetsRepository $repo)
    {
        return $this->countByDays($repo->query());
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges(): array
    {
        return [
            7  => __(':days Days', ['days' => 7]),
            14 => __(':days Days', ['days' => 14]),
            30 => __(':days Days', ['days' => 30]),
        ];
    }
}
