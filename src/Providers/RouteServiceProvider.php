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
     * Get the foundation route prefix.
     *
     * @return string
     */
    protected function getFoundationPrefix()
    {
        return config('arcanesoft.foundation.route.prefix', 'dashboard');
    }

    /**
     * Get the auth foundation route prefix.
     *
     * @return string
     */
    public function getFoundationAuthPrefix()
    {
        return $this->getFoundationPrefix() . '/' . config('arcanesoft.auth.route.prefix', 'authorization');
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
        $router->group([
            'prefix'    => $this->getFoundationAuthPrefix(),
            'namespace' => 'Arcanesoft\\Auth\\Http\\Controllers\\Foundation',
        ], function ($router) {
            (new Routes\Foundation\StatsRoutes)->map($router);
            (new Routes\Foundation\UsersRoutes)->map($router);
            (new Routes\Foundation\RolesRoutes)->map($router);
            (new Routes\Foundation\PermissionsRoutes)->map($router);
        });
    }
}
