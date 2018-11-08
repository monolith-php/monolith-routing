<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\Http\{Request, Response};

final class Router
{
    /** @var Collection */
    private $routes;
    /** @var RouteCompiler */
    private $compiler;
    /** @var RouteMatcher */
    private $matcher;
    /** @var RouteDispatcher */
    private $dispatcher;
    /** @var ReverseRouting */
    private $reverseRouting;
    /** @var CompiledRoutes */
    private $compiled;

    public function __construct(RouteCompiler $compiler, RouteMatcher $matcher, RouteDispatcher $dispatcher, ReverseRouting $reverseRouting)
    {
        $this->routes = new RouteDefinitions();
        $this->compiler = $compiler;
        $this->matcher = $matcher;
        $this->dispatcher = $dispatcher;
        $this->reverseRouting = $reverseRouting;
    }

    public function registerRoutes(RouteDefinitions $routes): void
    {
        $this->routes = $this->routes->merge($routes);
    }

    public function dispatch(Request $request): Response
    {
        // compile routes
        $this->compiled = $this->compiler->compile($this->routes);

        // match the route
        $matchedRoute = $this->matcher->match($request, $this->compiled);

        // dispatch request and send response
        return $this->dispatcher->dispatch($matchedRoute, $request);
    }

    public function url(string $controllerClass, array $arguments = []): string
    {
        $compiled = $this->compiled ?? $this->compiler->compile($this->routes);
        return $this->reverseRouting->route($compiled, $controllerClass, $arguments);
    }
}