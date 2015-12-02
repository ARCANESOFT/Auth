<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\CommandServiceProvider as ServiceProvider;

/**
 * Class     CommandServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommandServiceProvider extends ServiceProvider
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
        $this->registerPublishCommand();
        $this->registerSetupCommand();

        $this->commands($this->commands);
    }

    /**
     * Get the provided commands.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'arcanesoft.auth.commands.publish',
            'arcanesoft.auth.commands.setup',
        ];
    }

    /* ------------------------------------------------------------------------------------------------
     |  Command Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the publish command.
     */
    private function registerPublishCommand()
    {
        $this->app->singleton(
            'arcanesoft.auth.commands.publish',
            \Arcanesoft\Auth\Console\PublishCommand::class
        );

        $this->commands[] = \Arcanesoft\Auth\Console\PublishCommand::class;
    }

    /**
     * Register the setup command.
     */
    private function registerSetupCommand()
    {
        $this->app->singleton(
            'arcanesoft.auth.commands.setup',
            \Arcanesoft\Auth\Console\SetupCommand::class
        );

        $this->commands[] = \Arcanesoft\Auth\Console\SetupCommand::class;
    }
}
