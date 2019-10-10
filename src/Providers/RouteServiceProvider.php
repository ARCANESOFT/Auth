<?php

declare(strict_types=1);

namespace Arcanesoft\Auth\Providers;

use Arcanesoft\Auth\Http\Routes;
use Arcanesoft\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class     RouteServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The routes list.
     *
     * @var array
     */
    protected $routes = [
        Routes\DashboardRoutes::class,
        Routes\UsersRoutes::class,
        Routes\RolesRoutes::class,
        Routes\PermissionsRoutes::class,
        Routes\PasswordResetsRoutes::class,

        Routes\ProfileRoutes::class,
    ];
}
