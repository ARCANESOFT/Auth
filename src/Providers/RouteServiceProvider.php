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
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The admin controller namespace for the application.
     *
     * @var string
     */
    protected $adminNamespace = 'Arcanesoft\\Auth\\Http\\Controllers\\Admin';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Define the routes for the application.
     */
    public function map()
    {
        // Admin Routes
        $this->adminGroup(function () {
            $this->name('auth.')->group(function () {
                $this->mapAdminRoutes();
            });
        });
    }

    /* -----------------------------------------------------------------
     |  Other Methods
     | -----------------------------------------------------------------
     */

    /**
     * Define the foundation routes for the application.
     */
    protected function mapAdminRoutes()
    {
        Routes\Admin\ProfileRoutes::register();

        $this->prefix($this->config()->get('arcanesoft.auth.route.prefix', 'authorization'))
             ->group(function () {
                 Routes\Admin\StatsRoutes::register();
                 Routes\Admin\UsersRoutes::register();
                 Routes\Admin\RolesRoutes::register();
                 Routes\Admin\PermissionsRoutes::register();
                 Routes\Admin\PasswordResetsRoutes::register();
             });
    }

    /**
     * Register the route bindings.
     */
    protected function registerRouteBindings()
    {
        Routes\Admin\UsersRoutes::bindings();
        Routes\Admin\RolesRoutes::bindings();
        Routes\Admin\PermissionsRoutes::bindings();
    }
}
