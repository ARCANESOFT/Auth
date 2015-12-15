<?php namespace Arcanesoft\Auth;

use Arcanedev\Support\PackageServiceProvider;

/**
 * Class     AuthServiceProvider
 *
 * @package  Arcanesoft\Auth
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthServiceProvider extends PackageServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor       = 'arcanesoft';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package      = 'auth';

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    public function getBasePath()
    {
        return dirname(__DIR__);
    }

    /**
     * Get config key.
     *
     * @return string
     */
    protected function getConfigKey()
    {
        return str_slug($this->vendor . ' ' .$this->package, '.');
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerConfig();

        $this->app->register(\Arcanedev\Gravatar\GravatarServiceProvider::class);
        $this->app->register(\Arcanedev\LaravelAuth\LaravelAuthServiceProvider::class);
        $this->registerAuthUserModel();
        $this->app->register(Providers\AuthorizationServiceProvider::class);

        if ($this->app->runningInConsole()) {
            $this->app->register(Providers\CommandServiceProvider::class);
        }

        $this->app->register(Providers\ComposerServiceProvider::class);
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->registerPublishes();

        $this->app->register(Providers\RouteServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            //
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register user auth model.
     */
    private function registerAuthUserModel()
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $this->app['config'];

        $config->set('auth.model', \Arcanesoft\Auth\Models\User::class);
    }

    /**
     * Register publishes.
     */
    private function registerPublishes()
    {
        // Config
        $this->publishes([
            $this->getConfigFile() => config_path("{$this->vendor}/{$this->package}.php"),
        ], 'config');

        // Views
        $viewsPath = $this->getBasePath() . '/resources/views';
        $this->loadViewsFrom($viewsPath, 'auth');
        $this->publishes([
            $viewsPath => base_path('resources/views/vendor/auth'),
        ], 'views');

        // Translations
        $translationsPath = $this->getBasePath() . '/resources/lang';
        $this->loadTranslationsFrom($translationsPath, 'auth');
        $this->publishes([
            $translationsPath => base_path('resources/lang/vendor/auth'),
        ], 'lang');
    }
}
