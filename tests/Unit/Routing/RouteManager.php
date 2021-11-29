<?php

use Bespoke\Routing\RouteManager;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function setUp()
    {
        $this->mockRoutesDirectoryConfiguration();
        $this->resetManagerRoutes();
    }

    public function testValidMethodsRetrieval()
    {
        $supportedMethods = RouteManager::getValidMethods();

        $this->assertEquals(2, count($supportedMethods));
        $this->assertTrue(in_array('get', $supportedMethods));
        $this->assertTrue(in_array('post', $supportedMethods));
        $this->assertFalse(in_array('delete', $supportedMethods));
    }

    public function testRouteLoading()
    {
        RouteManager::loadRouteFiles();

        $routes = RouteManager::dumpAll();

        $expectedRouteMethods = 2;

        // Test POST routes (and only POST routes) are loaded
        $this->assertEquals($expectedRouteMethods, count($routes));
        $this->assertTrue(key_exists('post', $routes));

        $postRoutes = $routes['post'];

        // Test that the routes has been loaded correctly
        $this->assertEquals(1, count($postRoutes));
        $this->assertTrue(key_exists('/messages', $postRoutes));
        $this->assertEquals('SmsMessageHandler@send', $postRoutes['/messages']);
    }

    public function testGettingRoutesByMethod()
    {
        RouteManager::loadRouteFiles();

        $getRoutes = RouteManager::getRoutesByMethod('get');
        $postRoutes = RouteManager::getRoutesByMethod('post');

        $this->assertEquals(2, count($getRoutes));
        $this->assertEquals(1, count($postRoutes));
    }

    public function testAddingValidRoute()
    {
        RouteManager::addRoute('post', '/send', 'MyHandler@send');

        $postRoutes = RouteManager::getRoutesByMethod('post');
        $this->assertEquals(1, count($postRoutes));
        $this->assertTrue(key_exists('/send', $postRoutes));
        $this->assertEquals('MyHandler@send', $postRoutes['/send']);

    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Unknown HTTP method 'delete'.
     */
    public function testAddingRouteWithUnsupportedMethod()
    {
        RouteManager::addRoute('delete', '/send', 'MyHandler@send');
    }

    private function mockRoutesDirectoryConfiguration()
    {
        $demoFilesDirectory = realpath(__DIR__.'/../../demoFiles/routes/');

        $mockedConfig = \Mockery::mock('alias:App\Components\Config');

        $mockedConfig
            ->shouldReceive('get')
            ->withArgs(['routesDirectory'])
            ->andReturn($demoFilesDirectory);
    }

    private function resetManagerRoutes()
    {
        $routeManager = new RouteManager();
        $reflection = new ReflectionClass($routeManager);

        $validMethods = RouteManager::getValidMethods();

        foreach ($validMethods as $method) {
            $property = $reflection->getProperty($method);
            $property->setAccessible(true);
            $property->setValue(null, []);
            $property->setAccessible(false);
        }
    }
}

