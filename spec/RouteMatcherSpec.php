<?php namespace spec\Monolith\WebRouting;

use Monolith\Collections\Map;
use Monolith\Http\Request;
use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\RouteMatcher;
use PhpSpec\ObjectBehavior;
use spec\Monolith\DependencyInjection\ControllerStub;

class RouteMatcherSpec extends ObjectBehavior {

    function it_is_initializable() {

        $this->shouldHaveType(RouteMatcher::class);
    }

    function it_can_match_routes() {

        $serverVariables = new Map([
            'REQUEST_URI' => '/article/1',
            'REQUEST_METHOD' => 'stub',
        ]);

        $request = new Request(new Map, new Map, $serverVariables, new Map, new Map, new Map);

        $route = new CompiledRoute('stub', '/article/{id}', ControllerStub::class, 'index');

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }
}
