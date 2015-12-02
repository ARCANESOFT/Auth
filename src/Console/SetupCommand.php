<?php namespace Arcanesoft\Auth\Console;

use Arcanedev\Support\Bases\Command;

/**
 * Class     SetupCommand
 *
 * @package  Arcanesoft\Auth\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SetupCommand extends Command
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature   = 'auth:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup the Auth module.';

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->runSeeders();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Run the Auth database seeder.
     */
    private function runSeeders()
    {
        $this->call('db:seed', [
            '--class' => \Arcanesoft\Auth\Seeds\DatabaseSeeder::class
        ]);
    }
}
