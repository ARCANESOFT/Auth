<?php namespace Arcanesoft\Auth\Providers;

use Arcanesoft\Auth\Http\Routes;
use Arcanesoft\Core\Bases\RouteServiceProvider as ServiceProvider;

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
     */
    public function map()
    {
        $this->mapAdminRoutes();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Define the foundation routes for the application.
     */
    private function mapAdminRoutes()
    {
        $namespace = 'Arcanesoft\\Auth\\Http\\Controllers\\Admin';

        $this->group($this->getAdminAttributes('auth.', $namespace), function () {
            Routes\Admin\ProfileRoutes::register();
        });

        $attributes = $this->getAdminAttributes(
            'auth.', $namespace, $this->config()->get('arcanesoft.auth.route.prefix', 'authorization')
        );

        $this->group($attributes, function () {
            Routes\Admin\StatsRoutes::register();
            Routes\Admin\UsersRoutes::register();
            Routes\Admin\RolesRoutes::register();
            Routes\Admin\PermissionsRoutes::register();
            Routes\Admin\PasswordResetsRoutes::register();
        });

        // API ??
        $this->group($attributes, function () {
            Routes\Admin\ApiRoutes::register();
        });
    }
}
