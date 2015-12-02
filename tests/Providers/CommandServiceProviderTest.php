<?php namespace Arcanesoft\Auth\Tests\Providers;

use Arcanesoft\Auth\Providers\CommandServiceProvider;
use Arcanesoft\Auth\Tests\TestCase;

/**
 * Class     CommandServiceProviderTest
 *
 * @package  Arcanesoft\Auth\Tests\Providers
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class CommandServiceProviderTest extends TestCase
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /** @var CommandServiceProvider */
    private $provider;

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    public function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(CommandServiceProvider::class);
    }

    public function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Test Functions
     | ------------------------------------------------------------------------------------------------
     */
    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\Providers\CommandServiceProvider::class,
            \Arcanesoft\Auth\Providers\CommandServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            $this->assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provides()
    {
        $expected = [
            'arcanesoft.auth.commands.publish',
            'arcanesoft.auth.commands.setup',
        ];

        $this->assertEquals($expected, $this->provider->provides());
    }
}
