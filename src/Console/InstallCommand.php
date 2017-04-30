<?php namespace Arcanesoft\Auth\Console;

/**
 * Class     InstallCommand
 *
 * @package  Arcanesoft\Auth\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class InstallCommand extends Command
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
    protected $signature   = 'auth:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Auth module.';

    /* -----------------------------------------------------------------
     |  Main Functions
     | -----------------------------------------------------------------
     */

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->call('db:seed', [
            '--class' => \Arcanesoft\Auth\Seeds\DatabaseSeeder::class
        ]);
    }
}
