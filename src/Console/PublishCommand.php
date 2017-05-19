<?php namespace Arcanesoft\Auth\Console;

use Arcanedev\LaravelAuth\LaravelAuthServiceProvider;
use Arcanesoft\Auth\AuthServiceProvider;

/**
 * Class     PublishCommand
 *
 * @package  Arcanesoft\Auth\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PublishCommand extends Command
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'auth:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Publish auth config, migrations, assets and other stuff.';

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--provider' => LaravelAuthServiceProvider::class,
            '--tag'      => ['migrations', 'factories'],
        ]);

        $this->call('vendor:publish', [
            '--provider' => AuthServiceProvider::class,
        ]);
    }
}
