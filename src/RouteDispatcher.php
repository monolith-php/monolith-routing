<?php namespace Monolith\WebRouting;

use Monolith\HTTP\{Request, Response};

abstract class RouteDispatcher {

    abstract protected function makeController(string $controller);

    final public function dispatch(MatchedRoute $route, Request $request): Response {
        try {
            $controller = $this->makeController($route->controllerClass());
        } catch (\Exception $e) {
            throw new CouldNotResolveRouteController($route->controllerClass());
        }
        $response = $controller->{$route->controllerMethod()}($request);
        if ( ! $response instanceof Response) {
            throw new \UnexpectedValueException("Controller [{$route->controllerClass()}@{$route->controllerMethod()}] needs to return an implementation of Monolith\HTTP\Response.");
        }
        return $response;
    }
}