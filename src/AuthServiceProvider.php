<?php namespace Arcanesoft\Auth;

use Arcanesoft\Core\Bases\PackageServiceProvider;
use Arcanesoft\Core\CoreServiceProvider;

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
        $this->registerSidebarItems();
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(Providers\PackagesServiceProvider::class);
        $this->app->register(Providers\AuthorizationServiceProvider::class);
        $this->app->register(Providers\ComposerServiceProvider::class);

        if ($this->app->runningInConsole()) {
            $this->app->register(Providers\CommandServiceProvider::class);
        }
    }

    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $this->registerPublishes();

        $this->app->register(Providers\RouteServiceProvider::class);
        $this->app->register(Providers\ValidatorServiceProvider::class);
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

        // Sidebar items
        $this->publishSidebarItems();
    }
}
