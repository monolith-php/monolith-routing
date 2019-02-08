<?php namespace spec\Monolith\WebRouting;

use Monolith\Collections\Map;
use Monolith\DependencyInjection\Container;
use Monolith\Http\Request;
use Monolith\WebRouting\CompiledRoute;
use Monolith\WebRouting\MatchedRoute;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\RouteDispatcher;
use PhpSpec\ObjectBehavior;

class RouteDispatcherSpec extends ObjectBehavior
{
    private $container;

    function let()
    {
        $this->container = new Container();
        $this->beConstructedWith($this->container);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RouteDispatcher::class);
    }

    function it_can_dispatch_a_route_to_the_right_controller()
    {
        $matchedRoute = new MatchedRoute(new CompiledRoute('httpMethod', 'uri', ControllerStub::class, 'index', new Middlewares));
        $request = Request::fromGlobals();

        $response = $this->dispatch($matchedRoute, $request);

        $response->body()->shouldBe('controller stub response');
    }

    function it_can_dispatch_through_middleware()
    {
        $matchedRoute = new MatchedRoute(
            new CompiledRoute('httpMethod', 'uri', ControllerStub::class, 'index',
                Middlewares::list(MiddlewareStub::class, OtherMiddlewareStub::class)
            )
        );

        $request = Request::fromGlobals();

        $response = $this->dispatch($matchedRoute, $request);

        $response->body()->shouldBe('controller stub response 2 1');
    }

    function it_can_enrich_the_request_with_parameters()
    {
        $matchedRoute = new MatchedRoute(new CompiledRoute('httpMethod', '/action/{id}', ControllerStub::class, 'parameterExample', new Middlewares));

        $_SERVER['REQUEST_URI'] = '/action/123-abc';
        $request = Request::fromGlobals();

        $response = $this->dispatch($matchedRoute, $request);

        $response->body()->shouldBe('123-abc');
    }
}
