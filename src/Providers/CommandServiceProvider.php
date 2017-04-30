<?php namespace Arcanesoft\Auth\Providers;

use Arcanedev\Support\Providers\CommandServiceProvider as ServiceProvider;
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
        Console\InstallCommand::class,
    ];
}
