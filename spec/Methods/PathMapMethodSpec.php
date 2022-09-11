<?php namespace spec\Monolith\WebRouting\Methods;

use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\Methods\PathMapMethod;
use Monolith\WebRouting\Methods\PathRoutingMiddleware;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteParameters;
use PhpSpec\ObjectBehavior;

class PathMapMethodSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(PathMapMethod::class);
    }

    function it_can_define_a_path_route()
    {
        $route = $this::defineRoute('uri', 'root-path', 'controllerclass');
        $route->method()->shouldBe('path');
        $route->uri()->shouldBe('/uri/{one?}/{two?}/{three?}/{four?}/{five?}/{six?}/{seven?}');
        $route->controllerClass()->shouldBe('controllerclass');
        $route->middlewares()->shouldHaveCount(1);
    }

    function it_can_compile_a_path_route()
    {
        $route = new Route('path', 'uri', 'controller', new RouteParameters, Middlewares::list(PathRoutingMiddleware::class));

        $compiled = $this->compile($route);
        $compiled->shouldHaveType(CompiledRoutes::class);

        $compiled->head()->shouldHaveType(CompiledRoute::class);
        $compiled->head()->httpMethod()->shouldBe('get');
        $compiled->head()->controllerClass()->shouldBe('controller');
        $compiled->head()->controllerMethod()->shouldBe('get');
        $compiled->head()->middlewares()->equals(Middlewares::list(PathRoutingMiddleware::class))->shouldBe(true);
    }
}
