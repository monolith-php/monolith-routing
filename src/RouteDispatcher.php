<?php namespace Monolith\WebRouting;

use Monolith\HTTP\{Request, Response};

final class RouteDispatcher {

    /** @var Container */
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function dispatch(MatchedRoute $route, Request $request): Response {
        try {
            $controller = $this->makeController($route->controllerName());
        } catch (\Exception $e) {
            throw new CouldNotResolveRouteController($route->controllerName());
        }
        $response = $controller->{$route->controllerMethod()}($request, $route->parameters());
        if ( ! $response instanceof Response) {
            throw new \UnexpectedValueException("Controller [{$route->controllerName()}@{$route->controllerMethod()}] needs to return an implementation of Monolith\HTTP\Response.");
        }
        return $response;
    }

    protected function makeController(string $controller) {
        return $this->container->make($controller);
    }
}