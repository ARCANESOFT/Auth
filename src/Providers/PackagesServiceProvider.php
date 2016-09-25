<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Gravatar\GravatarServiceProvider;
use Arcanedev\LaravelAuth\LaravelAuthServiceProvider;
use Arcanedev\Support\ServiceProvider;
use Illuminate\Support\Arr;

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

        $this->configLaravelAuthPackage();
        $this->rebindModels();
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
        /** @var  \Illuminate\Contracts\Config\Repository  $config */
        $config = $this->config();

        $config->set('auth.model',   $config->get('arcanesoft.auth.users.model', \Arcanesoft\Auth\Models\User::class));
        $config->set('auth.table',   $config->get('arcanesoft.auth.users.table', 'users'));
        $config->set('laravel-auth', Arr::except($config->get('arcanesoft.auth'), ['route', 'hasher']));
    }

    /**
     * Rebind the auth models.
     */
    private function rebindModels()
    {
        $config   = $this->config();
        $bindings = [
            [
                'abstract' => \Arcanesoft\Contracts\Auth\Models\User::class,
                'concrete' => $config->get('arcanesoft.auth.users.model'),
            ],[
                'abstract' => \Arcanesoft\Contracts\Auth\Models\Role::class,
                'concrete' => $config->get('arcanesoft.auth.roles.model'),
            ],[
                'abstract' => \Arcanesoft\Contracts\Auth\Models\Permission::class,
                'concrete' => $config->get('arcanesoft.auth.permissions.model'),
            ],[
                'abstract' => \Arcanesoft\Contracts\Auth\Models\PermissionsGroup::class,
                'concrete' => $config->get('arcanesoft.auth.permissions-groups.model'),
            ],
        ];

        foreach ($bindings as $binding) {
            $this->bind($binding['abstract'], $binding['concrete']);
        }
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the config repository instance.
     *
     * @return \Illuminate\Contracts\Config\Repository
     */
    protected function config()
    {
        return $this->app['config'];
    }
}
