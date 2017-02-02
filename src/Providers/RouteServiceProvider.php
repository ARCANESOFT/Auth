<?php namespace Arcanesoft\Auth\Providers;

use Arcanesoft\Auth\Http\Routes;
use Arcanesoft\Core\Bases\RouteServiceProvider as ServiceProvider;
use Illuminate\Contracts\Routing\Registrar as RouterContract;

/**
 * Class     RouteServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function map(RouterContract $router)
    {
        $this->mapAdminRoutes($router);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define the foundation routes for the application.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    private function mapAdminRoutes(RouterContract $router)
    {
        $namespace = 'Arcanesoft\\Auth\\Http\\Controllers\\Admin';

        $router->group($this->getAdminAttributes('auth.', $namespace), function ($router) {
            Routes\Admin\ProfileRoutes::register($router);
        });

        $attributes = $this->getAdminAttributes(
            'auth.', $namespace, $this->config()->get('arcanesoft.auth.route.prefix', 'authorization')
        );

        $router->group($attributes, function ($router) {
            Routes\Admin\StatsRoutes::register($router);
            Routes\Admin\UsersRoutes::register($router);
            Routes\Admin\RolesRoutes::register($router);
            Routes\Admin\PermissionsRoutes::register($router);
            Routes\Admin\PasswordResetsRoutes::register($router);
        });

        // API ??
        $router->group($attributes, function ($router) {
            Routes\Admin\ApiRoutes::register($router);
        });
    }
}
