<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Gravatar\GravatarServiceProvider;
use Arcanedev\LaravelAuth\LaravelAuthServiceProvider;
use Arcanedev\Support\ServiceProvider;

/**
 * Class     PackagesServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PackagesServiceProvider extends ServiceProvider
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
        $this->registerGravatarPackage();
        $this->registerLaravelAuthPackage();

        $this->configLaravelAuthPackage();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Register Packages
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the gravatar package.
     */
    private function registerGravatarPackage()
    {
        $this->app->register(GravatarServiceProvider::class);
    }

    /**
     * Register the laravel auth package.
     */
    private function registerLaravelAuthPackage()
    {
        $this->app->register(LaravelAuthServiceProvider::class);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Config Packages
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Config the laravel auth package.
     */
    private function configLaravelAuthPackage()
    {
        /** @var \Illuminate\Config\Repository $config */
        $config      = $this->app['config'];
        $authConfigs = $config->get('arcanesoft.auth');

        $config->set('auth.model', \Arcanesoft\Auth\Models\User::class);
        $config->set('laravel-auth', array_except($authConfigs, ['route', 'hasher']));
    }
}
