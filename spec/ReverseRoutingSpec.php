<?php namespace spec\Monolith\WebRouting;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\ReverseRouting;
use Monolith\WebRouting\RouteDefinitions;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReverseRoutingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ReverseRouting::class);
    }

    function it_can_reverse_route_based_on_controller()
    {
        $routes = CompiledRoutes::list(
            new CompiledRoute('get', '/article', ControllerStub::class, 'index', new Middlewares)
        );

        $url = $this->route($routes, ControllerStub::class, [123]);

        $url->shouldBe('/article');
    }

    function it_can_produce_routes_with_an_argument()
    {
        $routes = CompiledRoutes::list(
            new CompiledRoute('get', '/article/{id}', ControllerStub::class, 'index', new Middlewares)
        );

        $url = $this->route($routes, ControllerStub::class, [123]);

        $url->shouldBe('/article/123');
    }

    function it_can_produce_routes_with_many_arguments()
    {
        $routes = CompiledRoutes::list(
            new CompiledRoute('get', '/article/{id}/{bid}/{cid}', ControllerStub::class, 'index', new Middlewares)
        );

        $url = $this->route($routes, ControllerStub::class, [123, 234, 345]);

        $url->shouldBe('/article/123/234/345');
    }
}