<?php namespace spec\Monolith\WebRouting;

use Monolith\Collections\Map;
use Monolith\DependencyInjection\Container;
use Monolith\Http\Request;
use Monolith\WebRouting\Middlewares;
use Monolith\WebRouting\ReverseRouting;
use Monolith\WebRouting\Route;
use Monolith\WebRouting\RouteCompiler;
use Monolith\WebRouting\RouteDefinitions;
use Monolith\WebRouting\RouteDispatcher;
use Monolith\WebRouting\RouteMatcher;
use Monolith\WebRouting\Router;
use PhpSpec\ObjectBehavior;
use spec\Monolith\WebRouting\Methods\StubMethod;

class RouterSpec extends ObjectBehavior
{
    /** @var RouteCompiler */
    private $compiler;

    function let()
    {
        $container = new Container;

        $this->compiler = new RouteCompiler;

        $matcher = new RouteMatcher;
        $dispatcher = new RouteDispatcher($container);

        $this->beConstructedWith($this->compiler, $matcher, $dispatcher, new ReverseRouting);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Router::class);
    }

    function it_can_dispatch_a_request()
    {
        // configure request
        $_SERVER['REQUEST_URI'] = '/article/1';
        $_SERVER['REQUEST_METHOD'] = 'get';

        $request = Request::fromGlobals();

        // register method compiler
        $this->compiler->registerMethodCompiler(new StubMethod);

        // compile routes
        $this->registerRoutes(RouteDefinitions::list(
            new Route('stub', '/article/{id}', ControllerStub::class, new Middlewares)
        ));

        $response = $this->dispatch($request);

        // check response
        $response->code()->shouldBe('200');
        $response->body()->shouldBe('controller stub response');
    }

    function it_can_reverse_route()
    {
        // register method compiler
        $this->compiler->registerMethodCompiler(new StubMethod);
        
        $this->registerRoutes(RouteDefinitions::list(
            new Route('stub', '/article/{id}/{hats}', ControllerStub::class, new Middlewares)
        ));

        $this->url(ControllerStub::class, ['bob', 'cob'])->shouldBe('/article/bob/cob');
    }
}
