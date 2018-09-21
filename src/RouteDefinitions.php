<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

final class RouteDefinitions extends Collection {

    private $transformFunction = null;

    public function __construct(array $items = []) {

        $this->items = $items;
    }

    public static function withTransformFunction(callable $transformFunction, ...$items): RouteDefinitions {

        $routes = new static($items);
        $routes->transformFunction = $transformFunction;
        return $routes;
    }

    public function flatten(callable $parentTransformFunction = null): RouteDefinitions {

        // flatten all route definitions
        $flatten = function ($route) {

            if ($route instanceof RouteDefinitions) {
                return $route->flatten();
            }

            return $route;
        };

        // reduce all route definitions to a single list
        $reduceToSingleList = function (RouteDefinitions $accumulation, $definition) {

            if ($definition instanceof RouteDefinitions) {
                return $accumulation->merge($definition);
            }

            return $accumulation->add($definition);
        };

        // map / reduce children into a single flat list of routes
        $flattenedRoutes = $this->map($flatten)->reduce($reduceToSingleList, new RouteDefinitions);

        // apply transformations
        return array_reduce(
            array_filter([$parentTransformFunction, $this->transformFunction]),
                function($routes, $transform) {
                    return $routes->map($transform);
                }, $flattenedRoutes);
    }
}