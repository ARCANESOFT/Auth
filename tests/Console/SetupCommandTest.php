<?php namespace Arcanesoft\Auth\Tests\Console;

use Arcanesoft\Auth\Tests\TestCase;

/**
 * Class     SetupCommandTest
 *
 * @package  Arcanesoft\Auth\Tests\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class SetupCommandTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_setup()
    {
        $this->migrate();
        $this->artisan('auth:install');

        static::assertDatabaseHas('auth_users', [
            'username'   => 'admin',
            'first_name' => 'Super',
            'last_name'  => 'ADMIN',
            'email'      => 'admin@example.com',
        ]);
    }
}
