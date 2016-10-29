<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\ServiceProvider;
use Arcanesoft\Auth\Console;

/**
 * Class     CommandServiceProvider
 *
 * @package  Arcanesoft\Auth\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommandServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Console commands.
     *
     * @var array
     */
    protected $commands = [
        Console\PublishCommand::class,
        Console\SetupCommand::class,
    ];

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Get the provided commands.
     *
     * @return array
     */
    public function provides()
    {
        return $this->commands;
    }
}
