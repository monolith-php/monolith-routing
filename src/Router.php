<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\HTTP\{Request, Response};
use Monolith\WebRouting\RouteHandling\RouteHandler;

class Router {

    /** @var Collection */
    private $routes;
    /** @var Collection */
    private $handlers;
    /** @var RoutesCompiler */
    private $compiler;
    /** @var RouteMatcher */
    private $matcher;
    /** @var RouteDispatcher */
    private $dispatcher;


    public function __construct(RoutesCompiler $compiler, RouteMatcher $matcher, RouteDispatcher $dispatcher) {
        $this->routes     = new Collection;
        $this->handlers   = new Collection;
        $this->compiler   = $compiler;
        $this->matcher    = $matcher;
        $this->dispatcher = $dispatcher;
    }

    public function registerHandler(RouteHandler $handler): void {
        $this->handlers = $this->handlers->add($handler);
    }

    public function registerRoutes(Collection $routes): void {
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