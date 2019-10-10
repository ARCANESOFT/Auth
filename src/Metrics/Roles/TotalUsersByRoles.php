<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Metrics\Roles;

use Arcanedev\LaravelMetrics\Metrics\Partition;
use Arcanesoft\Auth\Repositories\RolesRepository;
use Illuminate\Http\Request;

/**
 * Class     TotalUsersByRoles
 *
 * @package  Arcanesoft\Auth\Metrics\Roles
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class TotalUsersByRoles extends Partition
{
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Calculate the metric.
     *
     * @param  \Illuminate\Http\Request                        $request
     * @param  \Arcanesoft\Auth\Metrics\Roles\RolesRepository  $repo
     *
     * @return \Arcanedev\LaravelMetrics\Results\Result|mixed
     */
    public function calculate(Request $request, RolesRepository $repo)
    {
        // Calculate roles with users count
        $result = $repo->withCount(['users'])->get()->filter(function ($role) {
            return $role->users_count > 0;
        })->pluck('users_count', 'name');

        return $this->result($result)->sort('desc');
    }
}
