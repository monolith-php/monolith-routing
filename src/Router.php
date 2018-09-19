<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\HTTP\{Request, Response};

class Router {

    /** @var Collection */
    private $routes;
    /** @var RouteCompiler */
    private $compiler;
    /** @var RouteMatcher */
    private $matcher;
    /** @var RouteDispatcher */
    private $dispatcher;


    public function __construct(RouteCompiler $compiler, RouteMatcher $matcher, RouteDispatcher $dispatcher) {
        $this->routes     = new Collection;
        $this->compiler   = $compiler;
        $this->matcher    = $matcher;
        $this->dispatcher = $dispatcher;
    }

    public function registerHandler(MethodCompiler $handler): void {
        $this->compiler->registerHandler($handler);
    }

    public function registerRoutes(Collection $routes): void {
        $this->routes = $this->routes->merge($routes);
    }

    public function dispatch(Request $request): Response {
        // compile routes
        $compiled = $this->compiler->compile($this->routes);

        // match the route
        $matchedRoute = $this->matcher->match($request, $compiled);

        // dispatch request and send response
        return $this->dispatcher->dispatch($matchedRoute, $request);
    }
}