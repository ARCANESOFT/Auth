<?php namespace Arcanesoft\Auth\Tests\Console;

use Arcanesoft\Auth\Tests\TestCase;

/**
 * Class     PublishCommandTest
 *
 * @package  Arcanesoft\Auth\Tests\Console
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class PublishCommandTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_publish()
    {
        $this->assertSame(0, $this->artisan('auth:publish'));

        // TODO: Adding more assertions ??
    }
}
