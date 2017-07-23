<?php namespace Monolith\Routing;

use Monolith\Collections\Collection;
use Monolith\HTTP\{Request, Response};

class Router {

    /** @var RouteCollection */
    private $routes;
    /** @var RouteMatcher */
    private $matcher;
    /** @var RouteDispatcher */
    private $dispatcher;
    /** @var RouteCompiler */
    private $compiler;

    public function __construct(RouteDispatcher $dispatcher, RouteMatcher $matcher, RouteCompiler $compiler) {
        $this->compiler   = $compiler;
        $this->matcher    = $matcher;
        $this->dispatcher = $dispatcher;
        $this->routes     = new Collection;
    }

    public function addRoutes(Collection $routes) {
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