<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\HTTP\{Request, Response};
use Monolith\WebRouting\RouteHandling\RouteHandler;

class Router {

    /** @var RouteCollection */
    private $routes;
    /** @var RouteCompiler */
    private $compiler;
    /** @var RouteMatcher */
    private $matcher;
    /** @var RouteDispatcher */
    private $dispatcher;

    public function __construct(RouteCompiler $compiler, RouteMatcher $matcher, RouteDispatcher $dispatcher) {
        $this->compiler   = $compiler;
        $this->matcher    = $matcher;
        $this->dispatcher = $dispatcher;
        $this->routes     = new Collection;
    }

    public function registerHandler(RouteHandler $handler) {
        $this->compiler->registerHandler($handler);
    }

    public function registerRoutes(Collection $routes) {
        $this->routes = $this->routes->merge($routes);
    }

    public function dispatch(Request $request): Response {
        // compile routes
        $compiled = $this->compiler->compile($this->routes);

        // match the route
        $matchedRoute = $this->matcher->match($request, $compiled);

        // dispatch request and return response
        return $this->dispatcher->dispatch($matchedRoute, $request);
    }
}