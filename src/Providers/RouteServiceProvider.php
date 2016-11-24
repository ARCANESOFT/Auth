<?php namespace Arcanesoft\Auth\Providers;

use Arcanesoft\Auth\Http\Routes;
use Arcanesoft\Core\Bases\RouteServiceProvider as ServiceProvider;
use Illuminate\Contracts\Routing\Registrar as Router;
use Illuminate\Support\Arr;

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
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(Router $router)
    {
        $this->mapPublicRoutes($router);
        $this->mapFoundationRoutes($router);
    }

    /**
     * Define the public routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function mapPublicRoutes(Router $router)
    {
        $configs    = $this->config()->get('arcanesoft.auth.authentication');
        $attributes = Arr::get($configs, 'routes.global', [
            'prefix'    => 'auth',
            'as'        => 'auth::',
            'namespace' => 'Arcanesoft\\Auth\\Http\\Controllers\\Front',
        ]);

        $router->group($attributes, function (Router $router) {
            Routes\Front\AuthenticationRoutes::register($router);
            Routes\Front\RegisterRoutes::register($router);
            Routes\Front\PasswordResetRoutes::register($router);
            Routes\Front\ImpersonateRoutes::register($router);
        });

        $router->group(array_merge($attributes, [
            'prefix' => 'api',
            'as'     => $attributes['as'] . 'api.',
        ]), function (Router $router) {
            Routes\Front\ApiRoutes::register($router);
        });
    }

    /**
     * Define the foundation routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function mapFoundationRoutes(Router $router)
    {
        $attributes = array_merge($this->getFoundationRouteGroup(), [
            'as'        => 'auth::foundation.',
            'namespace' => 'Arcanesoft\\Auth\\Http\\Controllers\\Foundation',
        ]);

        $router->group($attributes, function (Router $router) {
            Routes\Foundation\ProfileRoutes::register($router);
        });

        $router->group(array_merge(
            $attributes,
            ['prefix' => $this->getFoundationAuthPrefix()]
        ), function (Router $router) {
            Routes\Foundation\StatsRoutes::register($router);
            Routes\Foundation\UsersRoutes::register($router);
            Routes\Foundation\RolesRoutes::register($router);
            Routes\Foundation\PermissionsRoutes::register($router);
            Routes\Foundation\PasswordResetsRoutes::register($router);
        });

        $router->group(array_merge(
            $attributes,
            ['prefix' => $this->getFoundationAuthPrefix()]
        ), function (Router $router) {
            Routes\Foundation\ApiRoutes::register($router);
        });
    }
}
