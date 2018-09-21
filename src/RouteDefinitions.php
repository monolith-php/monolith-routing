<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

final class RouteDefinitions extends Collection {

    private $middlewares;
    private $transformFunction = null;

    public function __construct(array $items = []) {

        $this->middlewares = new Middlewares;
        $this->items = $items;
    }

    public static function withTransformFunction(callable $transformFunction, ...$items): RouteDefinitions {

        $routes = new static($items);
        $routes->transformFunction = $transformFunction;
        return $routes;
    }

    public static function withMiddleware(Middlewares $middlewares, ...$items): RouteDefinitions {

        $routes = new static($items);
        $routes->middlewares = $routes->middlewares->merge($middlewares);
        return $routes;
    }

    public function flatten(Middlewares $parentMiddlewares): RouteDefinitions {

        $middlewares = $parentMiddlewares->merge($this->middlewares);

        $propagateMiddleware = function ($route) use ($middlewares) {

            if ($route instanceof RouteDefinitions) {
                return $route->flatten($middlewares);
            }

            return $route->addMiddlewares($middlewares);
        };

        $mergeDefinitions = function (RouteDefinitions $accumulation, $definition) {

            if ($definition instanceof RouteDefinitions) {
                return $accumulation->merge($definition);
            }

            return $accumulation->add($definition);
        };

        $flattenedRoutes = $this->map($propagateMiddleware)->reduce($mergeDefinitions, new RouteDefinitions);

        if ($this->transformFunction == null) {
            return $flattenedRoutes;
        }

        return $flattenedRoutes->map($this->transformFunction);
    }
}