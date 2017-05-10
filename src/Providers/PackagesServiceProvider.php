<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Gravatar\GravatarServiceProvider;
use Arcanedev\LaravelApiHelper\ApiHelperServiceProvider;
use Arcanedev\LaravelAuth\LaravelAuthServiceProvider;
use Arcanedev\LaravelAuth\Services\SocialAuthenticator;
use Arcanedev\LaravelImpersonator\ImpersonatorServiceProvider;
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
    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        parent::register();

        $this->registerApiHelperPackage();
        $this->registerGravatarPackage();
        $this->registerLaravelAuthPackage();
        $this->registerLaravelImpersonatorPackage();
    }

    /* -----------------------------------------------------------------
     |  Register Packages
     | -----------------------------------------------------------------
     */
    /**
     * Register the API Helper package.
     */
    private function registerApiHelperPackage()
    {
        $this->registerProvider(ApiHelperServiceProvider::class);
    }

    /**
     * Register the Gravatar package.
     */
    private function registerGravatarPackage()
    {
        $this->registerProvider(GravatarServiceProvider::class);
    }

    /**
     * Register the Laravel Auth package.
     */
    private function registerLaravelAuthPackage()
    {
        $this->registerProvider(LaravelAuthServiceProvider::class);

        $this->configLaravelAuthPackage();
        $this->rebindModels();
    }

    /**
     * Register the Laravel Impersonator package.
     */
    private function registerLaravelImpersonatorPackage()
    {
        $this->registerProvider(ImpersonatorServiceProvider::class);
        $this->configLaravelImpersonatorPackage();
    }

    /* -----------------------------------------------------------------
     |  Config Packages
     | -----------------------------------------------------------------
     */

    /**
     * Config the Laravel Auth package.
     */
    private function configLaravelAuthPackage()
    {
        /** @var  \Illuminate\Contracts\Config\Repository  $config */
        $config = $this->config();
        $config->set(
            'laravel-auth',
            Arr::except($config->get('arcanesoft.auth'), ['route', 'hasher', 'impersonation'])
        );

        if (SocialAuthenticator::isEnabled()) {
            $this->registerProvider(\Laravel\Socialite\SocialiteServiceProvider::class);
        }
    }

    /**
     * Config the Laravel Impersonator Package.
     */
    private function configLaravelImpersonatorPackage()
    {
        $config = $this->config();

        $config->set('impersonator', $config->get('arcanesoft.auth.impersonation', ['enabled' => false]));
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
}
