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
    }

    /* ------------------------------------------------------------------------------------------------
     |  Gravatar Package
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the gravatar package.
     */
    private function registerGravatarPackage()
    {
        $this->app->register(GravatarServiceProvider::class);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Auth Package
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the laravel auth package.
     */
    private function registerLaravelAuthPackage()
    {
        $this->app->register(LaravelAuthServiceProvider::class);

        $this->configLaravelAuthPackage();
        $this->rebindModels();
    }

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

    /**
     * Rebind the auth models.
     */
    private function rebindModels()
    {
        $bindings = [
            [
                'abstract' => \Arcanesoft\Contracts\Auth\Models\User::class,
                'concrete' => \Arcanesoft\Auth\Models\User::class,
            ],[
                'abstract' => \Arcanesoft\Contracts\Auth\Models\Role::class,
                'concrete' => \Arcanesoft\Auth\Models\Role::class,
            ],[
                'abstract' => \Arcanesoft\Contracts\Auth\Models\Permission::class,
                'concrete' => \Arcanesoft\Auth\Models\Permission::class,
            ],[
                'abstract' => \Arcanesoft\Contracts\Auth\Models\PermissionsGroup::class,
                'concrete' => \Arcanesoft\Auth\Models\PermissionsGroup::class,
            ],
        ];

        foreach ($bindings as $binding) {
            $this->bind($binding['abstract'], $binding['concrete']);
        }
    }
}
