<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;
use Monolith\DependencyInjection\Container;
use Monolith\Http\{Request, Response};
use function spec\Monolith\WebRouting\d;

final class RouteDispatcher {

    /** @var Container */
    private $container;

    public function __construct(Container $container) {

        $this->container = $container;
    }

    public function dispatch(MatchedRoute $route, Request $request): Response {

        // build controller
        $controller = $this->makeController($route->controllerClass());

        // build middlewares
        $middlewares = $route->middlewares();



        return Response::code200('controller stub response');
    }

    private function makeController(string $controller) {

        try {
            return $this->container->make($controller);
        } catch (\Exception $e) {
            throw new CanNotResolveControllerForRouting($controller);
        }
    }

}