<?php namespace Monolith\Routing;

use Monolith\Collections\{Collection, Map};
use Monolith\HTTP\{Request, Response};
use Monolith\Routing\Methods\Get;
use Monolith\Routing\Methods\Post;
use Monolith\Routing\Methods\RoutingMethod;

class Router {
    /** @var RouteCollection */
    private $routes;
    /** @var Collection */
    private $routingMethods;
    /** @var Map */
    private $controllerClasses;
    /** @var RouteMatcher */
    private $matcher;
    /** @var ControllerDispatcher */
    private $controllerDispatcher;

    public function __construct(ControllerDispatcher $controllerDispatcher) {
        $this->routes = new RouteCollection;
        $this->routingMethods = new Collection;
        $this->controllerClasses = new Map;
        $this->matcher = new RouteMatcher;
        $this->controllerDispatcher = $controllerDispatcher;
    }

    public function registerMethod(RoutingMethod $method) {
        // maps method names to method objects
        $this->routingMethods = $this->routingMethods->add($method);
    }

    public function addRoutes(RouteDeclaration $routes) {
        $this->routes = $this->routes->merge($routes->define());
    }

    public function handleRequest(Request $request): Response {
        // compile routes
        $compiled = new CompiledRoutes;
        /** @var Route $route */
        foreach ($this->routes as $route) {
            $method = $this->findRoutingMethod($route, $request);
            $compiledRoute = $method->compile($route);
            $compiled = $compiled->add($compiledRoute);
            $reflection = new \ReflectionClass($compiledRoute->controllerClass());
            foreach ($reflection->getInterfaceNames() as $routeHandler) {
                $controllers = new Map;
                // the first condition is to check against the routing method, it's not the request method
                if ($route->method() === 'get' && $routeHandler === Get::class) {
                    $controllers->add(Get::class, $route->uri());
                    $this->controllerClasses->add($compiledRoute->controllerClass(), $controllers);
                }
                if ($route->method() === 'post' && $routeHandler === Post::class) {
                    $controllers->add(Post::class, $route->uri());
                    $this->controllerClasses->add($compiledRoute->controllerClass(), $controllers);
                }
            }
        }

        // match the route
        $matchedRoute = $this->matcher->match($request, $compiled);

        // dispatch controller and return response
        return $this->controllerDispatcher->dispatch($matchedRoute, $request);
    }

    private function findRoutingMethod(Route $route, Request $request): RoutingMethod {
        /** @var RoutingMethod $method */
        foreach ($this->routingMethods as $method) {
            if ($method->handles($route->method(), $request->method())) {
                return $method;
            }
        }
        throw new \Exception("No method defined named {$route->method()}.");
    }
}