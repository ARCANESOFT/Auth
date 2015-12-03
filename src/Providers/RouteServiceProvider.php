<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\RouteServiceProvider as ServiceProvider;
use Arcanesoft\Auth\Http\Routes;
use Illuminate\Routing\Router;

/**
 * Class     RouteServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the routes namespace
     *
     * @return string
     */
    protected function getRouteNamespace()
    {
        return 'Arcanesoft\\Auth\\Http\\Routes';
    }

    /**
     * Get Foundation route group.
     *
     * @return array
     */
    protected function getFoundationRouteGroup()
    {
        return config('arcanesoft.foundation.route', []);
    }

    /**
     * Get the auth foundation route prefix.
     *
     * @return string
     */
    public function getFoundationAuthPrefix()
    {
        $prefix = array_get($this->getFoundationRouteGroup(), 'prefix', 'dashboard');

        return "$prefix/" . config('arcanesoft.auth.route.prefix', 'authorization');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define the routes for the application.
     *
     * @param  Router $router
     */
    public function map(Router $router)
    {
        $this->mapPublicRoutes($router);
        $this->mapFoundationRoutes($router);
    }

    /**
     * Define the public routes for the application.
     *
     * @param  Router  $router
     */
    private function mapPublicRoutes(Router $router)
    {
        $router->group([
            'prefix'    => 'auth',
            'as'        => 'auth::',
            'namespace' => 'Arcanesoft\\Auth\\Http\\Controllers\\Front',
        ], function ($router) {
            (new Routes\Front\AuthenticateRoutes)->map($router);
            (new Routes\Front\RegisterRoutes)->map($router);
            (new Routes\Front\ReminderRoutes)->map($router);
        });
    }

    /**
     * Define the foundation routes for the application.
     *
     * @param  Router  $router
     */
    private function mapFoundationRoutes(Router $router)
    {
        $attributes = array_merge($this->getFoundationRouteGroup(), [
            'as'        => 'auth::foundation.',
            'namespace' => 'Arcanesoft\\Auth\\Http\\Controllers\\Foundation',
        ]);

        $router->group($attributes, function (Router $router) {
            (new Routes\Foundation\ProfileRoutes)->map($router);
        });

        $router->group(array_merge(
            $attributes,
            ['prefix' => $this->getFoundationAuthPrefix()]
        ), function (Router $router) {
            (new Routes\Foundation\StatsRoutes)->map($router);
            (new Routes\Foundation\UsersRoutes)->map($router);
            (new Routes\Foundation\RolesRoutes)->map($router);
            (new Routes\Foundation\PermissionsRoutes)->map($router);
        });
    }
}
