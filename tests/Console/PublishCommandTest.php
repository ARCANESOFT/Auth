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
    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_publish()
    {
        $this->artisan('auth:publish');
    }
}
