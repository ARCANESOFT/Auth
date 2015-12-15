<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\ServiceProvider;
use Arcanesoft\Auth\ViewComposers;

/**
 * Class     ComposerServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class ComposerServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        //
    }

    /**
     * Register bindings in the container.
     */
    public function boot()
    {
        view()->composer(
            'auth::foundation.dashboard',
            ViewComposers\DashboardComposer::class
        );
    }
}
