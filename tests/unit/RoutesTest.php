<?php

use Controllers\IRoute;
use PHPUnit\Framework\TestCase;
use Controllers\Routes;


class RoutesTest extends TestCase
{
    /** @test */
    public function getRoutesShouldBeAnArray()
    {
        $routes = new Routes();
        // Get the routes from the Routes object
        $result = $routes->getRoutes();

        // Assertions on the routes
        $this->assertIsArray($result);
    }

    public function testIsInstanceOfIRoute()
    {
        $routes = new Routes();
        $this->assertInstanceOf(IRoute::class, $routes);
    }

    public function testGetRoutes()
    {
        $routesObject = new Routes();

        $result = $routesObject->getRoutes();
        $route = 'customer/review';
        $action = $result[$route]['GET']['action'];

        // Assertions on the routes
        $this->assertIsArray($result);
        $this->assertArrayHasKey($route, $result);
        $this->assertEquals($action, 'review');
    }
}
