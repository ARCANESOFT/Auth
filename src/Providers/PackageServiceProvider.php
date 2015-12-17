<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\ServiceProvider;

/**
 * Class     PackageServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PackageServiceProvider extends ServiceProvider
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
        $this->app->register(\Arcanedev\Gravatar\GravatarServiceProvider::class);
        $this->registerLaravelAuthPackage();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the laravel auth package.
     */
    private function registerLaravelAuthPackage()
    {
        $this->app->register(\Arcanedev\LaravelAuth\LaravelAuthServiceProvider::class);

        /** @var \Illuminate\Config\Repository $config */
        $config      = $this->app['config'];
        $authConfigs = $config->get('arcanesoft.auth');

        $config->set('auth.model', \Arcanesoft\Auth\Models\User::class);
        $config->set('laravel-auth', array_except($authConfigs, ['route', 'hasher']));
    }
}
