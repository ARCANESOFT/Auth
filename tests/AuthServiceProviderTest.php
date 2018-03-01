<?php namespace Arcanesoft\Auth\Tests;

use Arcanesoft\Auth\AuthServiceProvider;

/**
 * Class     AuthServiceProviderTest
 *
 * @package  Arcanesoft\Auth\Tests
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class AuthServiceProviderTest extends TestCase
{
    /* -----------------------------------------------------------------
     |  Properties
     | -----------------------------------------------------------------
     */

    /** @var  \Arcanesoft\Auth\AuthServiceProvider */
    private $provider;

    /* -----------------------------------------------------------------
     |  Main Methods
     | -----------------------------------------------------------------
     */

    protected function setUp()
    {
        parent::setUp();

        $this->provider = $this->app->getProvider(AuthServiceProvider::class);
    }

    protected function tearDown()
    {
        unset($this->provider);

        parent::tearDown();
    }

    /* -----------------------------------------------------------------
     |  Tests
     | -----------------------------------------------------------------
     */

    /** @test */
    public function it_can_be_instantiated()
    {
        $expectations = [
            \Illuminate\Support\ServiceProvider::class,
            \Arcanedev\Support\ServiceProvider::class,
            \Arcanedev\Support\PackageServiceProvider::class,
            \Arcanesoft\Auth\AuthServiceProvider::class,
        ];

        foreach ($expectations as $expected) {
            static::assertInstanceOf($expected, $this->provider);
        }
    }

    /** @test */
    public function it_can_provider()
    {
        $expected = [
            //
        ];

        static::assertEquals($expected, $this->provider->provides());
    }
}
