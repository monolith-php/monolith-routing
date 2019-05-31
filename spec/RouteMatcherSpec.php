<?php namespace spec\Monolith\WebRouting;

use Monolith\Http\Request;
use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\CompiledRoutes;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\RouteMatcher;
use Monolith\WebRouting\RouteParameters;
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

        $route = new CompiledRoute('stub', '/article/{id}', ControllerStub::class, 'index', new RouteParameters, new Middlewares);

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }

    function it_can_match_routes_with_special_characters()
    {
        $_SERVER['REQUEST_URI'] = '/article/1@bob.eu';
        $_SERVER['REQUEST_METHOD'] = 'stub';

        $request = Request::fromGlobals();

        $route = new CompiledRoute('stub', '/article/{id}', ControllerStub::class, 'index', new RouteParameters, new Middlewares);

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }

    function it_can_match_optional_segments_with_provided_uri_arguments()
    {
        $_SERVER['REQUEST_URI'] = '/article/1';
        $_SERVER['REQUEST_METHOD'] = 'stub';

        $request = Request::fromGlobals();

        $route = new CompiledRoute('stub', '/article/{maybe?}', ControllerStub::class, 'index', new RouteParameters, new Middlewares);

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }

    function it_can_match_optional_segments_without_provided_uri_segments()
    {
        $_SERVER['REQUEST_URI'] = '/article';
        $_SERVER['REQUEST_METHOD'] = 'stub';

        $request = Request::fromGlobals();

        $route = new CompiledRoute('stub', '/article/{maybe?}', ControllerStub::class, 'index', new RouteParameters, new Middlewares);

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }

    function it_can_match_multiple_optional_segments()
    {
        $_SERVER['REQUEST_URI'] = '/article/1/2';
        $_SERVER['REQUEST_METHOD'] = 'stub';

        $request = Request::fromGlobals();

        $route = new CompiledRoute('stub', '/article/{one?}/{two?}/{three?}', ControllerStub::class, 'index', new RouteParameters, new Middlewares);

        # it should match our first route.. because it's first and it matches
        $compiledRoutes = CompiledRoutes::list(
            $route,
            new CompiledRoute('stub', '/article/{one?}', ControllerStub::class, 'index', new RouteParameters, new Middlewares),
            new CompiledRoute('stub', '/article/{one?}/{two?}', ControllerStub::class, 'index', new RouteParameters, new Middlewares)
        );

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

        $route = new CompiledRoute('stub', '/article/{id}', ControllerStub::class, 'index', new RouteParameters, new Middlewares);

        $compiledRoutes = CompiledRoutes::list($route);

        $matchedRoute = $this->match($request, $compiledRoutes);

        $matchedRoute->httpMethod()->shouldBe('stub');
        $matchedRoute->uri()->shouldBe($route->uri());
        $matchedRoute->controllerClass()->shouldBe(ControllerStub::class);
        $matchedRoute->controllerMethod()->shouldBe('index');
    }
}
