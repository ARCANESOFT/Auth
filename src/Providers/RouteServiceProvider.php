<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\LaravelAuth\Services\SocialAuthenticator;
use Arcanedev\LaravelAuth\Services\UserImpersonator;
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
    public function getAdminAuthPrefix()
    {
        $prefix = Arr::get($this->getFoundationRouteGroup(), 'prefix', 'dashboard');

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
        $this->mapAdminRoutes($router);
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

            if (UserImpersonator::isEnabled())
                Routes\Front\ImpersonateRoutes::register($router);

            if (SocialAuthenticator::isEnabled())
                Routes\Front\SocialiteRoutes::register($router);
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
    private function mapAdminRoutes(Router $router)
    {
        $attributes = array_merge($this->getFoundationRouteGroup(), [
            'as'        => 'admin::auth.',
            'namespace' => 'Arcanesoft\\Auth\\Http\\Controllers\\Admin',
        ]);

        $router->group($attributes, function (Router $router) {
            Routes\Admin\ProfileRoutes::register($router);
        });

        $router->group(array_merge(
            $attributes,
            ['prefix' => $this->getAdminAuthPrefix()]
        ), function (Router $router) {
            Routes\Admin\StatsRoutes::register($router);
            Routes\Admin\UsersRoutes::register($router);
            Routes\Admin\RolesRoutes::register($router);
            Routes\Admin\PermissionsRoutes::register($router);
            Routes\Admin\PasswordResetsRoutes::register($router);
        });

        $router->group(array_merge(
            $attributes,
            ['prefix' => $this->getAdminAuthPrefix()]
        ), function (Router $router) {
            Routes\Admin\ApiRoutes::register($router);
        });
    }
}
