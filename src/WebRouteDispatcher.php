<?php namespace Monolith\WebRouting;

use Monolith\HTTP\{
    Request, Response
};
use Monolith\DependencyInjection\Container;

class WebRouteDispatcher implements RouteDispatcher {

    /** @var Container */
    private $container;

    public function __construct(Container $container) {
        $this->container = $container;
    }

    public function dispatch(MatchedRoute $route, Request $request): Response {
        try {
            $controller = $this->container->make($route->controllerClass());
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