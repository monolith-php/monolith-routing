<?php namespace Monolith\WebRouting;

use Monolith\DependencyInjection\Container;
use Monolith\Http\{Request, Response};

final class RouteDispatcher {

    /** @var Container */
    private $container;

    public function __construct(Container $container) {

        $this->container = $container;
    }

    public function dispatch(MatchedRoute $route, Request $request): Response {

        // dispatch through middlewares
        $output = $route->middlewares()->map(function($middleware) {
            var_dump($middleware);
        });

        var_dump($output);

        // dispatch to controller
        $controller = $this->makeController($route->controllerClass());

        // return response
        return $controller->{$route->controllerMethod()}($request);
    }

    private function makeController(string $controller) {

        try {
            return $this->container->make($controller);
        } catch (\Exception $e) {
            throw new CanNotResolveControllerForRouting($controller);
        }
    }
}