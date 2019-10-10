<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Metrics\PasswordResets;

use Arcanedev\LaravelMetrics\Metrics\Value;
use Arcanesoft\Auth\Policies\PasswordResetsPolicy;
use Arcanesoft\Auth\Repositories\PasswordResetsRepository;
use Illuminate\Http\Request;

/**
 * Class     TotalPasswordResets
 *
 * @package  Arcanesoft\Auth\Metrics\PasswordResets
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TotalPasswordResets extends Value
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Calculate the value of the metric.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return mixed
     */
    public function calculate(Request $request, PasswordResetsRepository $repo)
    {
        return $this->result($repo->count());
    }

    /**
     * Check if the current user is authorized.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return bool
     */
    public function authorize(Request $request): bool
    {
        return $request->user()->can(PasswordResetsPolicy::ability('metrics'));
    }
}
