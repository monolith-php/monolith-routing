<?php namespace spec\Monolith\WebRouting;

use Monolith\Http\Request;
use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\RouteMatcher;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\ControllerStub;

class RouteMatcherSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RouteMatcher::class);
    }

    function it_can_match_routes()
    {
        $_SERVER['REQUEST_URI'] = '/article/1';
        $_SERVER['REQUEST_METHOD'] = 'stub';

        $request = Request::fromGlobals();

        $route = new CompiledRoute('stub', '/article/{id}', ControllerStub::class, 'index', new Middlewares);

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }

    function it_ignores_query_strings_for_route_matching()
    {
        $_SERVER['REQUEST_URI'] = '/article/1?this=test';
        $_SERVER['REQUEST_METHOD'] = 'stub';

        $request = Request::fromGlobals();

        $route = new CompiledRoute('stub', '/article/{id}', ControllerStub::class, 'index', new Middlewares);

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }
}
