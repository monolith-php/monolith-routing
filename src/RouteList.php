<?php namespace Monolith\WebRouting;

use Monolith\Collections\Collection;

final class RouteList extends Collection implements RouteDefinition {

    private $transformFunction = null;

    public function __construct(array $items = []) {

        $this->items = $items;
    }

    public static function withTransformFunction(callable $transformFunction, ...$items): RouteList {

        $routes = new static($items);
        $routes->transformFunction = $transformFunction;
        return $routes;
    }

    public function flatten(callable $parentTransformFunction = null): RouteList {

        // flatten all route definitions
        $flatten = function ($route) {

            if ($route instanceof RouteList) {
                return $route->flatten();
            }

            return $route;
        };

        // reduce all route definitions to a single list
        $reduceToSingleList = function (RouteList $accumulation, $definition) {

            if ($definition instanceof RouteList) {
                return $accumulation->merge($definition);
            }

            return $accumulation->add($definition);
        };

        // map / reduce children into a single flat list of routes
        $flattenedRoutes = $this->map($flatten)->reduce($reduceToSingleList, new RouteList);

        // apply transformations
        return array_reduce(
            array_filter([$parentTransformFunction, $this->transformFunction]),
                function($routes, $transform) {
                    return $routes->map($transform);
                }, $flattenedRoutes);
    }
}